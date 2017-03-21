<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 巡访功能树模板
 * Class VisitTodoTemp
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="VisitTodoTemp")
 * @SWG\Property(name="fchildren_calculate", type="string", description="状态改变所依据的子项状态的计算方式（and , or）")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="ffunction_id", type="integer", description="定制功能表id")
 * @SWG\Property(name="ffunction_number", type="string", description="定制功能编号")
 * @SWG\Property(name="fgroup_id", type="string", description="分组标识")
 * @SWG\Property(name="fis_must_visit", type="integer", description="是否必巡")
 * @SWG\Property(name="flag", type="string", description="标识符")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fname", type="string", description="名称")
 * @SWG\Property(name="fnumber", type="string", description="编号")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="fparent_id", type="integer", description="父级id")
 * @SWG\Property(name="fstore_id", type="integer", description="store id")
 * @SWG\Property(name="id", type="integer", description="")
  */
class VisitTodoTemp extends BaseModel
{
	//
    protected $table = 'visit_todo_temps';

    public function children()
    {
        return $this->hasMany(VisitStoreTodo::class, 'fparent_id');
    }

    public function parent(){
        return $this->hasOne(VisitStoreTodo::class,'id','fparent_id');
    }
    public function ffunction(){
        return $this->hasOne(VisitFunction::class,'id','ffunction_id');
    }
}
