<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Busi\Message;

class MessageController extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Message($attributes);
	}

	public function fillQueryForIndex(Request $request, Builder &$query)
	{
		$query->with(['content','from']);
		parent::fillQueryForIndex($request, $query); // TODO: Change the autogenerated stub
	}

}