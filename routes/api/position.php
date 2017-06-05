<?php
/**
* @SWG\Resource(
*  resourcePath="/position",
*  description="Position"
* )
*/
Route::group(['prefix' => 'position', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/position",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="position-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:Position",
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
    Route::get('/', ['as' => 'Position.index', 'uses' => 'PositionController@index']);

    /**
    * @SWG\Api(
    *     path="/api/position/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="position-show",
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
    Route::get('/{id}', ['as' => 'Position.show', 'uses' => 'PositionController@show']);

    /**
    * @SWG\Api(
    *     path="/api/position",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="position-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fauditor_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="faudit_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreate_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdept_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fforbidder_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fforbid_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fforbid_status", description="", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fis_main", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fmodify_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fname", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fnumber", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fparpost_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fremark", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'Position.store', 'uses' => 'PositionController@store']);

    /**
    * @SWG\Api(
    *     path="/api/position/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="position-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fauditor_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="faudit_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreate_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdept_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fforbidder_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fforbid_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fforbid_status", description="", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fis_main", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fmodify_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fname", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fnumber", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fparpost_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fremark", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'Position.update', 'uses' => 'PositionController@update']);

    /**
    * @SWG\Api(
    *     path="/api/position/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="position-delete",
    *      summary="删除",
    *      notes="删除",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'Position.delete', 'uses' => 'PositionController@destroy']);

});