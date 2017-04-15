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
use App\Models\Busi\VisitLineStore;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\VisitStoreTodo;
use App\Models\Busi\VisitTodoCalendar;
use App\Models\Busi\VisitTodoGroup;
use Illuminate\Support\Facades\DB;

class VisitCalendarService
{
    /*
     * 按门店生成
     */
    public function byStore($store)
    {
        if ($store->fdocument_status!="C"||$store->fforbid_status!="A")
            return;

        DB::beginTransaction();
        try {
            $line = VisitLine::find($store->fline_id);

            //生成离当前门店线路 最近一天的日志
            $number = date('w') == 0 ? 7 : date('w');
            if ($line->fnumber >= $number) {
                $day = $line->fnumber - $number;
            } else {
                $day = 7 - $number + $line->fnumber;
            }
            $fdate = date("Y-m-d", strtotime('+' . $day . ' day'));

            $stores = collect([$store]);//转换集合使用deleteHistory方法
            $this->deleteHistory($stores, $fdate);

            $line_calendar = VisitLineCalendar::query()
                ->where('femp_id', $store->femp_id)
                ->where('fline_id', $line->id)
                ->where('fdate', $fdate)
                ->first();
            if (empty($line_calendar)) {
                $line_calendar = VisitLineCalendar::create([
                    'fdate' => $fdate,
                    'femp_id' => $store->femp_id,
                    'fline_id' => $line->id,
                ]);
            }

            $this->makeStore($line_calendar, $store->id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /*
     * 按天生成
     */
    public function byDay($fdate)
    {
        DB::beginTransaction();
        try {
            $line_number = date('w', strtotime($fdate));
            $line = VisitLine::query()->where('fnumber', $line_number)->first();

            //查询当天线路下的所有门店
            $vls = VisitLineStore::query()->where('fline_id', $line->id)->get();
            if (count($vls) == 0)
                return false;

            $stores = Store::query()->whereIn('id', $vls->pluck('fstore_id')->toArray())
                                    ->where('fdocument_status','C')
                                    ->where('fforbid_status','A')
                                    ->get();

            $this->deleteHistory($stores, $fdate);

            foreach ($stores as $s) {
                $line_calendar = VisitLineCalendar::query()
                    ->where('femp_id', $s->femp_id)
                    ->where('fline_id', $line->id)
                    ->where('fdate', $fdate)
                    ->first();
                if (empty($line_calendar)) {
                    $line_calendar = VisitLineCalendar::create([
                        'fdate' => $fdate,
                        'femp_id' => $s->femp_id,
                        'fline_id' => $line->id,
                    ]);
                }

                $this->makeStore($line_calendar, $s->id);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /*
     * 根据拜访方案生成
     */
    public function byGroup($group_id, $start_date, $end_date)
    {
        DB::beginTransaction();
        try {
            $group = VisitTodoGroup::find($group_id);
            $day = (strtotime($end_date) - strtotime($start_date)) / 86400;

//        $stores = $group->stores;

            for ($i = 0; $i < $day; $i++) {
                $fdate = date("Y-m-d", strtotime('+' . $i . ' day', strtotime($start_date)));
                $line_number = date("w", strtotime('+' . $i . ' day', strtotime($start_date)));
                $line_number = $line_number == 0 ? 7 : $line_number;

                $line = VisitLine::query()->where('fnumber', $line_number)->first();

                //查询方案所绑定的门店 是否有分配在当前线路下的
                $store_ids = $group->stores->where('fdocument_status','C')
                    ->where('fforbid_status','A')
                    ->pluck('id')->toArray();

                $vls = VisitLineStore::query()->where('fline_id', $line->id)->whereIn('fstore_id', $store_ids)->get();
                if (count($vls) == 0)
                    continue;

                $stores = Store::query()->whereIn('id', $vls->pluck('fstore_id')->toArray())->get();

                $this->deleteHistory($stores, $fdate);

                foreach ($stores as $s) {
                    $line_calendar = VisitLineCalendar::query()
                        ->where('femp_id', $s->femp_id)
                        ->where('fline_id', $line->id)
                        ->where('fdate', $fdate)
                        ->first();
                    if (empty($line_calendar)) {
                        $line_calendar = VisitLineCalendar::create([
                            'fdate' => $fdate,
                            'femp_id' => $s->femp_id,
                            'fline_id' => $line->id,
                        ]);
                    }

                    $this->makeStore($line_calendar, $s->id);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /*
     * 生成门店拜访日志
     */
    public function makeStore($line_calendar, $store_id)
    {
        $store_calendar = $line_calendar->store_calendars()->save(new VisitStoreCalendar([
            'fdate' => $line_calendar->fdate,
            'femp_id' => $line_calendar->femp_id,
            'fstore_id' => $store_id,
        ]));

        $this->makeTodo($store_calendar);

    }

    /*
     * 生成门店拜访事项
     */
    public function makeTodo($store_calendar)
    {
        $store = Store::find($store_calendar->fstore_id);
        $group = $store->todo_groups()
            ->where('fstart_date', '<=', $store_calendar->fdate)
            ->where('fend_date', '>=', $store_calendar->fdate)
            ->orderBy('fcreate_date', 'desc')
            ->first();

        if (!empty($group->todos)) {
            $this->saveTodoCalendars($group, $store_calendar);
        } else {
            $group = VisitTodoGroup::query()->where('fis_default', 1)->first();//默认方案
            if (count($group) > 0) {
                $this->saveTodoCalendars($group, $store_calendar);
            }
        }
    }

    /*
     * 根据方案生成具体拜访事项数据
     */
    public function saveTodoCalendars($group, $store_calendar)
    {
        $todo_ids = $group->todos->pluck('id')->toArray();
        $todos = VisitStoreTodo::query()->where('fparent_id', 0)->whereIn('id', $todo_ids)->get();

        foreach ($todos as $t) {
            $todo_calendars = $store_calendar->todo_calendars()->save(new VisitTodoCalendar([
                'fparent_id' => 0,
                'fdate' => $store_calendar->fdate,
                'femp_id' => $store_calendar->femp_id,
                'ftodo_id' => $t->id,
                'fis_must_visit' => $t->fis_must_visit
            ]));
            if (!empty($t->children)) {
                foreach ($t->children->whereIn('id', $todo_ids) as $child) {
                    $store_calendar->todo_calendars()->save(new VisitTodoCalendar([
                        'fparent_id' => $todo_calendars->id,
                        'fdate' => $store_calendar->fdate,
                        'femp_id' => $store_calendar->femp_id,
                        'ftodo_id' => $child->id,
                        'fis_must_visit' => $child->fis_must_visit
                    ]));
                }
            }
        }
    }

    /*
     * 删除原有数据
     */
    public function deleteHistory($stores, $fdate)
    {
        $store_ids = $stores->pluck('id')->toArray();
        $store_calendars = VisitStoreCalendar::query()
            ->whereIn('fstore_id', $store_ids)
            ->where('fdate', $fdate)
            ->get();
        foreach ($store_calendars as $s) {
            $s->todo_calendars()->delete();
        }
        VisitStoreCalendar::query()
            ->whereIn('fstore_id', $store_ids)
            ->where('fdate', $fdate)
            ->delete();
    }


}