<?php
/**
* @SWG\Resource(
*  resourcePath="/store-change",
*  description="门店变更记录"
* )
*/
Route::group(['prefix' => 'store-change', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/store-change",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="store-change-list",
    *      summary="门店变更记录列表",
    *      notes="门店变更记录列表",
    *      type="array",
    *     items="$ref:StoreChange",
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
    Route::get('/', ['as' => 'StoreChange.index', 'uses' => 'StoreChangeController@index']);

    /**
    * @SWG\Api(
    *     path="/api/store-change/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="store-change-show",
    *      summary="门店变更记录信息详情",
    *      notes="门店变更记录信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'StoreChange.show', 'uses' => 'StoreChangeController@show']);

    /**
    * @SWG\Api(
    *     path="/api/store-change",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="store-change-store",
    *      summary="新增门店变更记录",
    *      notes="新增门店变更记录",
    *      type="",
    *      @SWG\Parameters(
*          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'StoreChange.store', 'uses' => 'StoreChangeController@store']);

    /**
    * @SWG\Api(
    *     path="/api/store-change/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="store-change-update",
    *      summary="更新门店变更记录",
    *      notes="更新门店变更记录",
    *      type="",
    *      @SWG\Parameters(
*          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => 'StoreChange.update', 'uses' => 'StoreChangeController@update']);

    /**
    * @SWG\Api(
    *     path="/api/store-change/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="store-change-delete",
    *      summary="删除门店变更记录",
    *      notes="删除门店变更记录",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'StoreChange.delete', 'uses' => 'StoreChangeController@destroy']);

});