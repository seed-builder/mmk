<?php
/**
* @SWG\Resource(
*  resourcePath="/stock-in-item",
*  description="StockInItem"
* )
*/
Route::group(['prefix' => 'stock-in-item', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/stock-in-item",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-in-item-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:StockInItem",
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
    Route::get('/', ['as' => 'StockInItem.index', 'uses' => 'StockInItemController@index']);

    /**
    * @SWG\Api(
    *     path="/api/stock-in-item/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-in-item-show",
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
    Route::get('/{id}', ['as' => 'StockInItem.show', 'uses' => 'StockInItemController@show']);

    /**
    * @SWG\Api(
    *     path="/api/stock-in-item",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="stock-in-item-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbase_qty", description="销售基本单位数量（瓶）(订单数量*商品表FRotio)", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fbase_unit", description="基本单位", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="fmaterial_id", description="物料内码id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fqty", description="订单数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fsale_unit", description="销售单位", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fstock_in_id", description="入库ID", required=false,type="integer", paramType="form", defaultValue="0" ),
                *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'StockInItem.store', 'uses' => 'StockInItemController@store']);

    /**
    * @SWG\Api(
    *     path="/api/stock-in-item/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="stock-in-item-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbase_qty", description="销售基本单位数量（瓶）(订单数量*商品表FRotio)", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fbase_unit", description="基本单位", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="fmaterial_id", description="物料内码id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fqty", description="订单数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fsale_unit", description="销售单位", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fstock_in_id", description="入库ID", required=false,type="integer", paramType="form", defaultValue="0" ),
                *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'StockInItem.update', 'uses' => 'StockInItemController@update']);

    /**
    * @SWG\Api(
    *     path="/api/stock-in-item/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="stock-in-item-delete",
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
    Route::delete('/{id}', ['as' => 'StockInItem.delete', 'uses' => 'StockInItemController@destroy']);

});