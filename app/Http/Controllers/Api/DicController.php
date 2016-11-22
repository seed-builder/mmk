<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dic as Entity;

class DicController extends ApiController
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $type = $request->input('type', '');
        $arr = explode(',', $type);
        if(empty($type)){
            $data = Entity::all();
        }else{
            $data = Entity::whereIn('type', $arr)->get();
        }
        $result = [];
        if(count($arr)>1) {
            $data->each(function ($item, $key) use ($result) {
                $result[$item->type] = $item;
            });
        }else{
            $result = $data ;
        }
        return response($result, 200);
    }

    public function newEntity(array $attributes = [])
    {
        return new Entity($attributes);
    }
}
