<?php

namespace App\Http\Controllers\Api;

use App\Events\VisitDetailCompletedEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\VisitPzbz;

class VisitPzbzController extends ApiController
{
    //

    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new VisitPzbz($attributes);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
		$data = $request->all();
		unset($data['_sign']);
		$logId = $data['flog_id'];
		$entity = VisitPzbz::where('flog_id', $logId)->first();
		if($entity){
			$entity->fill($data);
			$entity->save();
		}else{
			//$entity = $this->newEntity($data);
			$entity = VisitPzbz::create($data);
		}
		if($entity){
			$status =   200 ;
			//event(new VisitDetailCompletedEvent($entity->flog_id));
		}else{
			$status =   400;
		}
		//$entity = Entity::create($data);
		//$re = $entity->save();
		//LogSvr::Sync()->info('ModelCreated : '.json_encode($entity));
		//$status =   200 ;
		return response($entity, $status);
	}
}
