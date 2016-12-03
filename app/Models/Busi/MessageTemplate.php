<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessageTemplate
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="MessageTemplate")
 * @SWG\Property(name="content", type="string", description="内容模板，变量（#name）")
 * @SWG\Property(name="title", type="string", description="标题")
 * @SWG\Property(name="type", type="integer", description="消息模板类型： 0-jpush 推送")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 */
class MessageTemplate extends BaseModel
{
    //
    protected $table = 'bd_message_templates';
}
