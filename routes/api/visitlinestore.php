<?php
/**
* @SWG\Resource(
*  resourcePath="/visit-line-store",
*  description="VisitLineStore"
* )
*/
Route::group(['prefix' => 'visit-line-store', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/visit-line-store",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="visit-line-store-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:VisitLineStore",
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
    Route::get('/', ['as' => 'VisitLineStore.index', 'uses' => 'VisitLineStoreController@index']);

    /**
    * @SWG\Api(
    *     path="/api/visit-line-store/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="visit-line-store-show",
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
    Route::get('/{id}', ['as' => 'VisitLineStore.show', 'uses' => 'VisitLineStoreController@show']);

    /**
    * @SWG\Api(
    *     path="/api/visit-line-store",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="visit-line-store-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="数据状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="femp_id", description="employee id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fline_id", description="线路id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fstore_id", description="门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fweek_day", description="week day", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'VisitLineStore.store', 'uses' => 'VisitLineStoreController@store']);

    /**
    * @SWG\Api(
    *     path="/api/visit-line-store/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="visit-line-store-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="数据状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="femp_id", description="employee id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fline_id", description="线路id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fstore_id", description="门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fweek_day", description="week day", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'VisitLineStore.update', 'uses' => 'VisitLineStoreController@update']);

    /**
    * @SWG\Api(
    *     path="/api/visit-line-store/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="visit-line-store-delete",
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
    Route::delete('/{id}', ['as' => 'VisitLineStore.delete', 'uses' => 'VisitLineStoreController@destroy']);

});