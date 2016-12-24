<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Store;

class StoreController extends ApiController
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $entity = Store::find($id);
        if(!empty($entity->customer)){
            $entity->customer_name = $entity->customer->fname;
        }
        return response($entity, 200);
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
        $postalcode = City::getPostalCode($data['fprovince'], $data['fcity'], $data['fcountry']);
        if($postalcode){
            $count = Store::where('fpostalcode', $postalcode)->count();
            $data['fnumber'] = $data['fpostalcode'] . sprintf('%05d', ($count+1));
        }

        unset($data['_sign']);
        $entity = $this->newEntity($data);
        //$entity = Entity::create($data);
        $re = $entity->save();
        $status = $re ? 200 : 400;
        return response($entity, $status);
    }

    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new Store($attributes);
    }
}
