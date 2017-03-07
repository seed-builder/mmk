<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/2/5
 * Time: 0:53
 */
Route::get('city/list', function (\Illuminate\Http\Request $request){
    $data = $request->all();
    $citys = \App\Models\City::query()->where('ParentId',$data['parent_id'])->get();
    return response()->json([
        'code' => 200,
        'result' => 'success',
        'data' => $citys
    ]);
});
Route::get('city/getCity', function (\Illuminate\Http\Request $request){
    $data = $request->all();
    $entity = \App\Models\City::find($data['id']);

    return response()->json([
        'code' => 200,
        'result' => 'success',
        'data' => $entity
    ]);
});

