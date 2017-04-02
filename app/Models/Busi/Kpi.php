<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class Kpi
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Kpi")
 * @SWG\Property(name="fapr", type="number", description="四月份kpi指标")
 * @SWG\Property(name="faug", type="number", description="八月份kpi指标")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdec", type="number", description="十二月份kpi指标")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="feb", type="number", description="二月份kpi指标")
 * @SWG\Property(name="femp_id", type="integer", description="")
 * @SWG\Property(name="fjan", type="number", description="一月份kpi指标")
 * @SWG\Property(name="fjul", type="number", description="七月份kpi指标")
 * @SWG\Property(name="fjun", type="number", description="六月份kpi指标")
 * @SWG\Property(name="fmar", type="number", description="三月份kpi指标")
 * @SWG\Property(name="fmay", type="number", description="五月份kpi指标")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fnov", type="number", description="十一月份kpi指标")
 * @SWG\Property(name="foct", type="number", description="十月份kpi指标")
 * @SWG\Property(name="fsep", type="number", description="九月份kpi指标")
 * @SWG\Property(name="ftype", type="integer", description="指标类型（0-目标拜访量,1-目标销售额）")
 * @SWG\Property(name="fyear", type="integer", description="年份")
 * @SWG\Property(name="id", type="integer", description="")
  */
class Kpi extends BaseModel
{
	//
	protected $table = 'bd_kpis';
	protected $guarded = ['id'];

//    public $validateRules=[
//        'fjan' => 'required',
//        'feb' => 'required',
//        'fmar' => 'required',
//        'fapr' => 'required',
//        'fmay' => 'required',
//        'fjun' => 'required',
//        'fjul' => 'required',
//        'faug' => 'required',
//        'fsep' => 'required',
//        'foct' => 'required',
//        'fnov' => 'required',
//        'fdec' => 'required',
//    ];

	public function employee(){
	    return $this->hasOne(Employee::class,'id','femp_id');
    }
}
