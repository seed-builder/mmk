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
    
    public function organization(){
    	return $this->hasOne(Organization::class, 'id', 'forg_id');
    }
    
    public function employee(){
    	return $this->hasOne(Employee::class, 'id', 'femp_id');
    }
    
    public function line(){
    	return $this->hasOne(VisitLine::class, 'id', 'fline_id');
    }

    /*
     * 生成线路拜访日历
     * 参数 femp_id fline_id fdate
     */
    public function makeCalendar($femp_id,$fline_id,$fdate){
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


}
