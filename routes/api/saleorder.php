<?php
/**
* @SWG\Resource(
*  resourcePath="/sale-order",
*  description="SaleOrder"
* )
*/
Route::group(['prefix' => 'sale-order', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/sale-order",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="sale-order-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:SaleOrder",
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
    Route::get('/', ['as' => 'SaleOrder.index', 'uses' => 'SaleOrderController@index']);

    /**
    * @SWG\Api(
    *     path="/api/sale-order/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="sale-order-show",
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
    Route::get('/{id}', ['as' => 'SaleOrder.show', 'uses' => 'SaleOrderController@show']);

    /**
    * @SWG\Api(
    *     path="/api/sale-order",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="sale-order-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbill_no", description="订单单号(门店编码+日期)", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcust_id", description="经销商ID", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdate", description="下单日期", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="femp_id", description="业务员id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsend_status", description="发货状态(A-未发货，B-发货中，C-已到货)", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fstore_id", description="门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'SaleOrder.store', 'uses' => 'SaleOrderController@store']);

    /**
    * @SWG\Api(
    *     path="/api/sale-order/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="sale-order-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbill_no", description="订单单号(门店编码+日期)", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcust_id", description="经销商ID", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdate", description="下单日期", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="femp_id", description="业务员id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsend_status", description="发货状态(A-未发货，B-发货中，C-已到货)", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fstore_id", description="门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'SaleOrder.update', 'uses' => 'SaleOrderController@update']);

    /**
    * @SWG\Api(
    *     path="/api/sale-order/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="sale-order-delete",
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
    Route::delete('/{id}', ['as' => 'SaleOrder.delete', 'uses' => 'SaleOrderController@destroy']);

});