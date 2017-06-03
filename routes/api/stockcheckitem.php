<?php
/**
* @SWG\Resource(
*  resourcePath="/stock-check-item",
*  description="经销商库存盘点单详情"
* )
*/
Route::group(['prefix' => 'stock-check-item', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/stock-check-item",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-check-item-list",
    *      summary="经销商库存盘点单详情列表",
    *      notes="经销商库存盘点单详情列表",
    *      type="array",
    *     items="$ref:StockCheckItem",
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
    Route::get('/', ['as' => 'StockCheckItem.index', 'uses' => 'StockCheckItemController@index']);

    /**
    * @SWG\Api(
    *     path="/api/stock-check-item/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-check-item-show",
    *      summary="经销商库存盘点单信息详情",
    *      notes="经销商库存盘点单信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'StockCheckItem.show', 'uses' => 'StockCheckItemController@show']);

    /**
    * @SWG\Api(
    *     path="/api/stock-check-item",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="stock-check-item-store",
    *      summary="新增经销商库存盘点单详情",
    *      notes="新增经销商库存盘点单详情",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="box_qty", description="盘点瓶数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="bottle_qty", description="盘点箱数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fmaterial_id", description="物料id", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstock_check_id", description="盘点单id", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'StockCheckItem.store', 'uses' => 'StockCheckItemController@store']);

    /**
    * @SWG\Api(
    *     path="/api/stock-check-item/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="stock-check-item-update",
    *      summary="更新经销商库存盘点单详情",
    *      notes="更新经销商库存盘点单详情",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="box_qty", description="盘点瓶数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="bottle_qty", description="盘点箱数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => 'StockCheckItem.update', 'uses' => 'StockCheckItemController@update']);

	/**
	 * @SWG\Api(
	 *     path="/api/stock-check-item/{id}",
	 *     @SWG\Operation(
	 *      method="DELETE",
	 *      nickname="stock-check-item-delete",
	 *      summary="删除经销商库存盘点详情",
	 *      notes="删除经销商库存盘点详情",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::delete('/{id}', ['as' => 'StockCheckItem.delete', 'uses' => 'StockCheckItemController@destroy']);


});