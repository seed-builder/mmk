<?php

namespace App\Models\Busi;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class MessageContent
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="MessageContent")
 * @SWG\Property(name="content", type="string", description="内容")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="files", type="string", description="附件id集合（bd_resources id）")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="title", type="string", description="标题")
 * @SWG\Property(name="subtitle", type="string", description="副标题")
 * @SWG\Property(name="type", type="integer", description="消息类型（0-系统公告,1-公司发文,2-流程消息,3-任务消息）")
  */
class MessageContent extends BaseModel
{
	//
	protected $table = 'bd_message_contents';
	protected $guarded = ['id'];

	public function creator(){
	    return $this->hasOne(User::class,'id','fcreator_id');
    }
    public function modifyer(){
        return $this->hasOne(User::class,'id','fmodify_id');
    }

}
