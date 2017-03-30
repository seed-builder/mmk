<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class Message
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Message")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="from_id", type="integer", description="")
 * @SWG\Property(name="from_type", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="message_content_id", type="integer", description="")
 * @SWG\Property(name="read", type="integer", description="")
 * @SWG\Property(name="to_id", type="integer", description="")
 * @SWG\Property(name="to_type", type="string", description="")
  */
class Message extends BaseModel
{
	//
	protected $table = 'bd_messages';
	protected $guarded = ['id'];

	public function content(){
		return $this->belongsTo(MessageContent::class, 'message_content_id');
	}
}
