<?php
/**
* @SWG\Resource(
*  resourcePath="/sale-order-item",
*  description="SaleOrderItem"
* )
*/
Route::group(['prefix' => 'sale-order-item', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/sale-order-item",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="sale-order-item-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:SaleOrderItem",
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
    Route::get('/', ['as' => 'SaleOrderItem.index', 'uses' => 'SaleOrderItemController@index']);

    /**
    * @SWG\Api(
    *     path="/api/sale-order-item/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="sale-order-item-show",
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
    Route::get('/{id}', ['as' => 'SaleOrderItem.show', 'uses' => 'SaleOrderItemController@show']);

    /**
    * @SWG\Api(
    *     path="/api/sale-order-item",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="sale-order-item-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbase_qty", description="销售基本单位数量（瓶）(订单数量*商品表FRotio)", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fbase_unit", description="基本单位", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmaterial_id", description="物料内码id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fqty", description="订单数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fsale_order_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fsale_unit", description="销售单位", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fsend_base_qty", description="发货基本单位数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fsend_qty", description="发货数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'SaleOrderItem.store', 'uses' => 'SaleOrderItemController@store']);

    /**
    * @SWG\Api(
    *     path="/api/sale-order-item/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="sale-order-item-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbase_qty", description="销售基本单位数量（瓶）(订单数量*商品表FRotio)", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fbase_unit", description="基本单位", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmaterial_id", description="物料内码id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fqty", description="订单数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fsale_order_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fsale_unit", description="销售单位", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fsend_base_qty", description="发货基本单位数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fsend_qty", description="发货数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'SaleOrderItem.update', 'uses' => 'SaleOrderItemController@update']);

    /**
    * @SWG\Api(
    *     path="/api/sale-order-item/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="sale-order-item-delete",
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
    Route::delete('/{id}', ['as' => 'SaleOrderItem.delete', 'uses' => 'SaleOrderItemController@destroy']);

});