<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 线路日历
 * Class VisitLineCalendar
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="VisitLineCalendar")
 * @SWG\Property(name="fleader_id", type="integer", description="员工上级id")
 * @SWG\Property(name="femp_id", type="integer", description="员工id")
 * @SWG\Property(name="fline_id", type="integer", description="线路id")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="fstatus", type="string", description="线路巡访状态")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdate", type="string", description="日期")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 */
class VisitLineCalendar extends BaseModel
{
    //
    protected $table = 'visit_line_calendar';
    
    protected $with = ['organization','employee','line'];

    public $filter = true;
    
    public function organization(){
    	return $this->hasOne(Organization::class, 'id', 'forg_id');
    }
    
    public function employee(){
    	return $this->hasOne(Employee::class, 'id', 'femp_id');
    }
    
    public function line(){
    	return $this->hasOne(VisitLine::class, 'id', 'fline_id');
    }

    public function store_calendars(){
        return $this->hasMany(VisitStoreCalendar::class,'fline_calendar_id');
    }

    /*
     * 生成线路拜访日历
     * 参数 femp_id fline_id fdate
     */
    public function makeCalendar($femp_id,$fline_id,$fdate){
        //删除原有数据
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

        $vlc = VisitLineCalendar::create([
            'fdate' => $fdate,
            'femp_id' => $femp_id,
            'fline_id' => $fline_id,
        ]);

        $model = new VisitStoreCalendar();

        $vls = VisitLineStore::query()->where('fline_id',$fline_id)->where('femp_id',$femp_id)->get();
        foreach ($vls as $v){
            $model->makeCalendar($femp_id,$v->fstore_id,$vlc->id,$fdate);
        }


    }

    /*
     * 生成指定门店拜访日历
     */
    public function makeLineStoreCalendar($femp_id,$fline_id,$fstore_id,$fdate){
        //删除原有数据
        $model = new VisitStoreCalendar();

        $model->where('femp_id', $femp_id)
            ->where('fdate', $fdate)
            ->where('fstore_id', $fstore_id)
            ->delete();

        $line_calendar = VisitLineCalendar::query()
            ->where('femp_id', $femp_id)
            ->where('fdate', $fdate)
            ->where('fline_id', $fline_id)
            ->first();

        if (!empty($line_calendar)){
            $model->makeCalendar($femp_id,$fstore_id,$line_calendar->id,$fdate);
        }else{
            $vlc = VisitLineCalendar::create([
                'fdate' => $fdate,
                'femp_id' => $femp_id,
                'fline_id' => $fline_id,
            ]);

            $model->makeCalendar($femp_id,$fstore_id,$vlc->id,$fdate);
        }
    }

    public function adminFilter($queryBuilder, $request)
    {
        $data = $request->all();
        if (!empty($data['tree'])){
            $emp = Employee::find($data['tree']['nodeid']);
            if (empty($emp)) {
                $dept = Department::find($data['tree']['nodeid']);
                $emp_ids = $dept->getAllEmployeeByDept()->pluck('id')->toArray();

                $queryBuilder->whereIn('femp_id', $emp_ids);
            } else {
                $queryBuilder->where('femp_id', $data['tree']['nodeid']);
            }
        }

        if (!empty($data['filter'])){
            foreach ($data['filter'] as $f){
                $filter_name = $f['name'];
                if ($filter_name=="femp"&&!empty($f['value'])){
                    $ids = Employee::query()->where('fname','like','%'.$f['value'].'%')->pluck('id');
                    $queryBuilder->whereIn('femp_id', $ids);
                }else{
                    $queryBuilder=$this->adminFilterQuery($queryBuilder,$f);
                }
            }
        }

        return $queryBuilder;
    }

}
