<?php

namespace App\Models\Busi;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class Message
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Message")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="from_id", type="integer", description="发送人id")
 * @SWG\Property(name="to_id", type="integer", description="接收人id")
 * @SWG\Property(name="message_content_id", type="integer", description="内容id")
 * @SWG\Property(name="read", type="integer", description="是否已读")
 * @SWG\Property(name="type", type="integer", description="消息类型（0-系统公告,1-公司发文,2-流程消息,3-任务消息）")
 * @SWG\Property(name="extra_id", type="integer", description="附加数据id")
 * @SWG\Property(name="extra_type", type="string", description="附加数据类型")
  */
class Message extends BaseModel
{
	//
	protected $table = 'bd_messages';
	protected $guarded = ['id'];

	public function content(){
		return $this->belongsTo(MessageContent::class, 'message_content_id');
	}

	public function from(){
		return $this->belongsTo(User::class, 'from_id');
	}

	public function to(){
		return $this->belongsTo(User::class, 'to_id');
	}
}
