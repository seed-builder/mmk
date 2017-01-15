<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class MessageTemplate
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="MessageTemplate")
 * @SWG\Property(name="content", type="string", description="内容模板，变量（#name）")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="title", type="string", description="标题")
 * @SWG\Property(name="type", type="integer", description="消息模板类型： 0-jpush 推送")
  */
class MessageTemplate extends BaseModel
{
	//
	protected $table = 'bd_message_templates';
	protected $guarded = ['id'];
}
