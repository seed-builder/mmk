<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class VisitTodoGroup
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="VisitTodoGroup")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="fend_date", type="string", description="有效期截止日期")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fname", type="string", description="名称")
 * @SWG\Property(name="fremark", type="string", description="备注")
 * @SWG\Property(name="fstart_date", type="string", description="有效期开始日期")
 * @SWG\Property(name="id", type="integer", description="")
  */
class VisitTodoGroup extends BaseModel
{
	//
	protected $table = 'visit_todo_groups';
	protected $guarded = ['id'];

    public function todos()
    {
        return $this->belongsToMany(VisitStoreTodo::class, 'visit_todo_group_details', 'fgroup_id', 'fstore_todo_id');
    }

    public function stores(){
        return $this->belongsToMany(Store::class, 'visit_todo_group_stores', 'fgroup_id', 'fstore_id');
    }
}
