<?php
/**
* @SWG\Resource(
*  resourcePath="/stock-out",
*  description="StockOut"
* )
*/
Route::group(['prefix' => 'stock-out', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/stock-out",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-out-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:StockOut",
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
    Route::get('/', ['as' => 'StockOut.index', 'uses' => 'StockOutController@index']);

    /**
    * @SWG\Api(
    *     path="/api/stock-out/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="stock-out-show",
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
    Route::get('/{id}', ['as' => 'StockOut.show', 'uses' => 'StockOutController@show']);

    /**
    * @SWG\Api(
    *     path="/api/stock-out",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="stock-out-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbill_no", description="出库单号(门店编码+日期)", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fcust_id", description="经销商ID", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fdate", description="出库日期", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fneed_rec_date", description="预计到货日期", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="frec_date", description="到货确认日期", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="frec_status", description="到货状态(0未到货 1已到货)", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fsbill_no", description="来源单号", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fstore_id", description="门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fuser_id", description="到货确认人id", required=false,type="integer", paramType="form", defaultValue="0" ),
                *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'StockOut.store', 'uses' => 'StockOutController@store']);

    /**
    * @SWG\Api(
    *     path="/api/stock-out/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="stock-out-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbill_no", description="出库单号(门店编码+日期)", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fcust_id", description="经销商ID", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fdate", description="出库日期", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fneed_rec_date", description="预计到货日期", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="frec_date", description="到货确认日期", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="frec_status", description="到货状态(0未到货 1已到货)", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fsbill_no", description="来源单号", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fstore_id", description="门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fuser_id", description="到货确认人id", required=false,type="integer", paramType="form", defaultValue="0" ),
                *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'StockOut.update', 'uses' => 'StockOutController@update']);

    /**
    * @SWG\Api(
    *     path="/api/stock-out/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="stock-out-delete",
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
    Route::delete('/{id}', ['as' => 'StockOut.delete', 'uses' => 'StockOutController@destroy']);

});