<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/3/23
 * Time: 22:30
 */

namespace App\Services;


use App\Models\Busi\Store;
use App\Models\Busi\VisitLine;
use App\Models\Busi\VisitLineCalendar;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\VisitStoreTodo;
use App\Models\Busi\VisitTodoCalendar;
use App\Models\Busi\VisitTodoGroup;
use Illuminate\Support\Facades\DB;

class VisitCalendarService
{

    /*
     * 生成指定方案日历
     */
    public function makeGroup($group_id, $start_date, $end_date)
    {
        DB::beginTransaction();
        try {
            $group = VisitTodoGroup::find($group_id);
            $day = (strtotime($end_date) - strtotime($start_date)) / 86400;

            for ($i = 0; $i < $day; $i++) {
                foreach ($group->stores as $s) {
                    $this->makeStore($s->id, date("Y-m-d", strtotime('+' . $i . ' day', strtotime($start_date))));
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

    }

    /*
     * 生成指定门店拜访日历
     */
    public function makeStore($fstore_id, $fdate)
    {
        DB::beginTransaction();
        try {
            //删除原有数据
            $store = Store::find($fstore_id);

            VisitStoreCalendar::query()->where('femp_id', $store->femp_id)
                ->where('fdate', $fdate)
                ->where('fstore_id', $fstore_id)
                ->delete();
            VisitLineCalendar::query()
                ->where('femp_id', $store->femp_id)
                ->where('fdate', $fdate)
                ->where('fline_id', $store->fline_id)
                ->delete();

            $vlc = VisitLineCalendar::create([
                'fdate' => $fdate,
                'femp_id' => $store->femp_id,
                'fline_id' => $store->fline_id,
            ]);

            $this->makeStoreCalendar($store->femp_id, $fstore_id, $vlc->id, $fdate);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /*
     * 生成所有门店拜访日历
     */
    public function makeAllStores($fdate)
    {
        DB::beginTransaction();
        try {
            $fnumber = date('w', strtotime($fdate));
            $line = VisitLine::query()->where('fnumber', $fnumber)->first();

            $vls = VisitLineStore::query()->where('fline_id', $line->id)->get();
            foreach ($vls as $v) {
                $femp_id = $v->femp_id;

                VisitLineCalendar::query()
                    ->where('femp_id', $femp_id)
                    ->where('fdate', $fdate)
                    ->delete();
                VisitStoreCalendar::query()
                    ->where('femp_id', $femp_id)
                    ->where('fdate', $fdate)
                    ->delete();
                VisitTodoCalendar::query()
                    ->where('femp_id', $femp_id)
                    ->where('fdate', $fdate)
                    ->delete();

                $this->makeLineCalendar($femp_id, $line->id, date('Y-m-d'));

            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

    }

    /*
     * 生成线路日历
     */
    protected function makeLineCalendar($femp_id, $fline_id, $fdate)
    {
        $vlc = VisitLineCalendar::create([
            'fdate' => $fdate,
            'femp_id' => $femp_id,
            'fline_id' => $fline_id,
        ]);

        $vls = VisitLineStore::query()->where('fline_id', $fline_id)->where('femp_id', $femp_id)->get();
        foreach ($vls as $v) {
            $this->makeStoreCalendar($femp_id, $v->fstore_id, $vlc->id, $fdate);
        }
    }

    /*
     * 生成门店日历
     */
    protected function makeStoreCalendar($femp_id, $fstore_id, $fline_calendar_id, $fdate)
    {
        $vsc = VisitStoreCalendar::create([
            'fdate' => $fdate,
            'femp_id' => $femp_id,
            'fline_calendar_id' => $fline_calendar_id,
            'fstore_id' => $fstore_id,
        ]);

        $this->makeTodoCalendar($fdate, $femp_id, $vsc->id, $fstore_id);
    }

    /*
     * 生成事项日历
     */
    protected function makeTodoCalendar($fdate, $femp_id, $fstore_calendar_id, $fstore_id)
    {
        $store = Store::find($fstore_id);
        $group = $store->todo_groups()
            ->where('fstart_date', '<=', $fdate)
            ->where('fend_date', '>=', $fdate)
            ->orderBy('fcreate_date', 'desc')
            ->first();

        if (!empty($group->todos)) {
            $todo_ids = $group->todos->pluck('id')->toArray();
            $todos = VisitStoreTodo::query()->where('fparent_id', 0)->whereIn('id', $todo_ids)->get();

            foreach ($todos as $t) {
                $vtc = VisitTodoCalendar::create([
                    'fparent_id' => 0,
                    'fdate' => $fdate,
                    'femp_id' => $femp_id,
                    'fstore_calendar_id' => $fstore_calendar_id,
                    'ftodo_id' => $t->id,
                    'fis_must_visit' => $t->fis_must_visit
                ]);

                if (!empty($t->children)) {
                    foreach ($t->children->whereIn('id', $todo_ids) as $child) {
                        VisitTodoCalendar::create([
                            'fparent_id' => $vtc->id,
                            'fdate' => $fdate,
                            'femp_id' => $femp_id,
                            'fstore_calendar_id' => $fstore_calendar_id,
                            'ftodo_id' => $child->id,
                            'fis_must_visit' => $child->fis_must_visit
                        ]);
                    }
                }
            }
        }else{
            $group = VisitTodoGroup::query()->where('fis_default',1)->first();//默认方案
            if (count($group)>0){
                $todo_ids = $group->todos->pluck('id')->toArray();
                $todos = VisitStoreTodo::query()->where('fparent_id', 0)->whereIn('id', $todo_ids)->get();

                foreach ($todos as $t) {
                    $vtc = VisitTodoCalendar::create([
                        'fparent_id' => 0,
                        'fdate' => $fdate,
                        'femp_id' => $femp_id,
                        'fstore_calendar_id' => $fstore_calendar_id,
                        'ftodo_id' => $t->id,
                        'fis_must_visit' => $t->fis_must_visit
                    ]);

                    if (!empty($t->children)) {
                        foreach ($t->children->whereIn('id', $todo_ids) as $child) {
                            VisitTodoCalendar::create([
                                'fparent_id' => $vtc->id,
                                'fdate' => $fdate,
                                'femp_id' => $femp_id,
                                'fstore_calendar_id' => $fstore_calendar_id,
                                'ftodo_id' => $child->id,
                                'fis_must_visit' => $child->fis_must_visit
                            ]);
                        }
                    }
                }
            }

        }

    }


}