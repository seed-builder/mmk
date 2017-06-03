<?php
/**
* @SWG\Resource(
*  resourcePath="/stock-in",
*  description="StockIn"
* )
*/
Route::group(['prefix' => 'stock-in', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/stock-in",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-in-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:StockIn",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="user_id", description="用户id", required=false, type="integer", paramType="query", defaultValue="1"),
    *          @SWG\Parameter(name="page", description="当前页", required=false, type="integer", paramType="query", defaultValue="1"),
    *          @SWG\Parameter(name="pageSize", description="页大小", required=false, type="integer", paramType="query", defaultValue="10"),
    *          @SWG\Parameter(name="sort", description="排序", required=false, type="string", paramType="query", defaultValue="id asc"),
    *          @SWG\Parameter(name="search", description="查询条件（数组的json格式, 键里面可带有比较符号，不带默认为: =）", required=false, type="string", paramType="query", defaultValue="{&quot;id >=&quot;:1}"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *    )
    * )
    */
    Route::get('/', ['as' => 'StockIn.index', 'uses' => 'StockInController@index']);

    /**
    * @SWG\Api(
    *     path="/api/stock-in/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-in-show",
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
    Route::get('/{id}', ['as' => 'StockIn.show', 'uses' => 'StockInController@show']);

    /**
    * @SWG\Api(
    *     path="/api/stock-in",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="stock-in-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbill_no", description="订单单号(门店编码+日期)", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fcust_id", description="经销商ID", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="fin_date", description="到货日期", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fsend_date", description="发货日期", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fsend_status", description="发货状态(A-未发货，B-发货中，C-已到货)", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="fuser_id", description="到货确认人id", required=false,type="integer", paramType="form", defaultValue="0" ),
                *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'StockIn.store', 'uses' => 'StockInController@store']);

    /**
    * @SWG\Api(
    *     path="/api/stock-in/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="stock-in-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbill_no", description="订单单号(门店编码+日期)", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fcust_id", description="经销商ID", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="fin_date", description="到货日期", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fsend_date", description="发货日期", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fsend_status", description="发货状态(A-未发货，B-发货中，C-已到货)", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="fuser_id", description="到货确认人id", required=false,type="integer", paramType="form", defaultValue="0" ),
                *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'StockIn.update', 'uses' => 'StockInController@update']);

    /**
    * @SWG\Api(
    *     path="/api/stock-in/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="stock-in-delete",
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
    Route::delete('/{id}', ['as' => 'StockIn.delete', 'uses' => 'StockInController@destroy']);

});