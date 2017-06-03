<?php
/**
* @SWG\Resource(
*  resourcePath="/stock-check",
*  description="经销商库存盘点单"
* )
*/
Route::group(['prefix' => 'stock-check', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/stock-check",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-check-list",
    *      summary="经销商库存盘点单列表",
    *      notes="经销商库存盘点单列表",
    *      type="array",
    *     items="$ref:StockCheck",
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
    Route::get('/', ['as' => 'StockCheck.index', 'uses' => 'StockCheckController@index']);

    /**
    * @SWG\Api(
    *     path="/api/stock-check/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-check-show",
    *      summary="经销商库存盘点单信息详情",
    *      notes="经销商库存盘点单信息详情",
    *      type="StockCheck",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'StockCheck.show', 'uses' => 'StockCheckController@show']);

	/**
	 * @SWG\Api(
	 *     path="/api/stock-check/find-or-create/{cust_id}",
	 *     @SWG\Operation(
	 *      method="GET",
	 *      nickname="stock-check-find-or-create",
	 *      summary="查询或者创建 经销商库存盘点单信息详情",
	 *      notes="查询或者创建 经销商库存盘点单信息详情",
	 *      type="StockCheck",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="cust_id", description="经销商id", required=true, type="integer", paramType="path", defaultValue="1"),
	 *          @SWG\Parameter(name="checker_id", description="当前盘点人用户id（user id）", required=true, type="integer", paramType="query", defaultValue="1"),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::get('/find-or-create/{cust_id}', ['as' => 'StockCheck.findOrCreate', 'uses' => 'StockCheckController@findOrCreate']);


	/**
    * @SWG\Api(
    *     path="/api/stock-check",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="stock-check-store",
    *      summary="新增经销商库存盘点单",
    *      notes="新增经销商库存盘点单",
    *      type="StockCheck",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fchecker_id", description="盘点人id(user id)", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcheck_date", description="盘点日期", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcheck_status", description="0-盘点中,1-盘点完成，2-取消盘点", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fcreate_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcust_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcust_user_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'StockCheck.store', 'uses' => 'StockCheckController@store']);

    /**
    * @SWG\Api(
    *     path="/api/stock-check/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="stock-check-update",
    *      summary="更新经销商库存盘点单",
    *      notes="更新经销商库存盘点单",
    *      type="StockCheck",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fchecker_id", description="盘点人id(user id)", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcheck_date", description="盘点日期", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcheck_status", description="0-盘点中,1-盘点完成，2-取消盘点", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fcreate_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcust_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcust_user_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
                *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => 'StockCheck.update', 'uses' => 'StockCheckController@update']);

    /**
    * @SWG\Api(
    *     path="/api/stock-check/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="stock-check-delete",
    *      summary="删除经销商库存盘点单",
    *      notes="删除经销商库存盘点单",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'StockCheck.delete', 'uses' => 'StockCheckController@destroy']);

});