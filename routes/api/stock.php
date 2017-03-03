<?php
/**
* @SWG\Resource(
*  resourcePath="/stock",
*  description="Stock"
* )
*/
Route::group(['prefix' => 'stock', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/stock",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-list",
    *      summary="库存列表",
    *      notes="库存列表",
    *      type="array",
    *     items="$ref:Stock",
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
    Route::get('/', ['as' => 'Stock.index', 'uses' => 'StockController@index']);

    /**
    * @SWG\Api(
    *     path="/api/stock/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-show",
    *      summary="库存信息详情",
    *      notes="库存信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'Stock.show', 'uses' => 'StockController@show']);

    /**
    * @SWG\Api(
    *     path="/api/stock",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="stock-store",
    *      summary="新增库存",
    *      notes="新增库存",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbase_eqty", description="库存基本单位数量（瓶）", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="feqty", description="瓶数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fhqty", description="箱数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="flog_id", description="拜访执行明细visit_todo_calendar id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fmeterial_id", description="物料内码id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fold_eqty", description="上次盘点库存基本单位数量(瓶)", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fsale_hqty", description="建议销售数量(箱)", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fstore_id", description="门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="ftime", description="盘点时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'Stock.store', 'uses' => 'StockController@store']);

    /**
    * @SWG\Api(
    *     path="/api/stock/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="stock-update",
    *      summary="更新库存",
    *      notes="更新库存",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbase_eqty", description="库存基本单位数量（瓶）", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="feqty", description="瓶数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fhqty", description="箱数量", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="flog_id", description="拜访执行明细visit_todo_calendar id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fmeterial_id", description="物料内码id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fold_eqty", description="上次盘点库存基本单位数量(瓶)", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fsale_hqty", description="建议销售数量(箱)", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fstore_id", description="门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="ftime", description="盘点时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'Stock.update', 'uses' => 'StockController@update']);

    /**
    * @SWG\Api(
    *     path="/api/stock/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="stock-delete",
    *      summary="删除库存",
    *      notes="删除库存",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'Stock.delete', 'uses' => 'StockController@destroy']);

});