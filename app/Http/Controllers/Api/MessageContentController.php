<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Busi\MessageContent;

class MessageContentController extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new MessageContent($attributes);
	}

	public function show($id)
	{
        $entity = MessageContent::find($id);
	    return view('api.message.view',compact('entity'));
		//return parent::show($id); // TODO: Change the autogenerated stub
	}
}