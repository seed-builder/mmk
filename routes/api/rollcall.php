<?php
/**
* @SWG\Resource(
*  resourcePath="/rollcall",
*  description="Rollcall"
* )
*/
Route::group(['prefix' => 'rollcall', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/rollcall",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="rollcall-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:Rollcall",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="page", description="当前页", required=false, type="integer", paramType="query", defaultValue="1"),
    *          @SWG\Parameter(name="pageSize", description="页大小", required=false, type="integer", paramType="query", defaultValue="10"),
    *          @SWG\Parameter(name="sort", description="排序", required=false, type="string", paramType="query", defaultValue="id asc"),
    *          @SWG\Parameter(name="search", description="查询条件（数组的json格式, 键里面可带有比较符号，不带默认为: =）", required=false, type="string", paramType="query", defaultValue="{&quot;id >=&quot;:1}"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *    )
    * )
    */
    Route::get('/', ['as' => 'Rollcall.index', 'uses' => 'RollcallController@index']);

    /**
    * @SWG\Api(
    *     path="/api/rollcall/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="rollcall-show",
    *      summary="信息详情",
    *      notes="信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'Rollcall.show', 'uses' => 'RollcallController@show']);

    /**
    * @SWG\Api(
    *     path="/api/rollcall",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="rollcall-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="address", description="地址", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="femp_id", description="employee id", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="flatitude", description="百度地图纬度", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="flongitude", description="百度地图经度", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmode", description="模式", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fphotos", description="图片id 集合， 逗号隔开", required=true,type="string", paramType="form", defaultValue="" ),
                *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'Rollcall.store', 'uses' => 'RollcallController@store']);

    /**
    * @SWG\Api(
    *     path="/api/rollcall/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="rollcall-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="address", description="地址", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="femp_id", description="employee id", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="flatitude", description="百度地图纬度", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="flongitude", description="百度地图经度", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmode", description="模式", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fphotos", description="图片id 集合， 逗号隔开", required=false,type="string", paramType="form", defaultValue="" ),
                *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => 'Rollcall.update', 'uses' => 'RollcallController@update']);

    /**
    * @SWG\Api(
    *     path="/api/rollcall/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="rollcall-delete",
    *      summary="删除",
    *      notes="删除",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'Rollcall.delete', 'uses' => 'RollcallController@destroy']);

});