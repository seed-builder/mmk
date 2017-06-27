<?php
/**
* @SWG\Resource(
*  resourcePath="/fin-statement",
*  description="FinStatement"
* )
*/
Route::group(['prefix' => 'fin-statement', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/fin-statement",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="fin-statement-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:FinStatement",
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
    Route::get('/', ['as' => 'FinStatement.index', 'uses' => 'FinStatementController@index']);

    /**
    * @SWG\Api(
    *     path="/api/fin-statement/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="fin-statement-show",
    *      summary="信息详情",
    *      notes="信息详情",
    *      type="FinStatement",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'FinStatement.show', 'uses' => 'FinStatementController@show']);

    /**
    * @SWG\Api(
    *     path="/api/fin-statement",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="fin-statement-store",
    *      summary="新增",
    *      notes="新增",
    *      type="FinStatement",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="abstract", description="摘要", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="bal_amount", description="余额", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="bill_date", description="业务日期", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="bill_no", description="单据编码", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="bill_type", description="单据类型", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="cur_amount", description="本期发生额", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="cust_id", description="经销商id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="cust_name", description="经销商名称", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="cust_num", description="经销商编号", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
                    *          @SWG\Parameter(name="month", description="月份", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="print_status", description="0-未打印，1-已打印 ", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="project_no", description="方案编号 ", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="remarks", description="备注", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="seq", description="打印排序使用", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="srcbill_no", description="源单编号", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="status", description="0-未对账，1-已对账 ", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="year", description="年份", required=false,type="integer", paramType="form", defaultValue="0" ),
        *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'FinStatement.store', 'uses' => 'FinStatementController@store']);

    /**
    * @SWG\Api(
    *     path="/api/fin-statement/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="fin-statement-update",
    *      summary="更新",
    *      notes="更新",
    *      type="FinStatement",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="abstract", description="摘要", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="bal_amount", description="余额", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="bill_date", description="业务日期", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="bill_no", description="单据编码", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="bill_type", description="单据类型", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="cur_amount", description="本期发生额", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="cust_id", description="经销商id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="cust_name", description="经销商名称", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="cust_num", description="经销商编号", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
                    *          @SWG\Parameter(name="month", description="月份", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="print_status", description="0-未打印，1-已打印 ", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="project_no", description="方案编号 ", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="remarks", description="备注", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="seq", description="打印排序使用", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="srcbill_no", description="源单编号", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="status", description="0-未对账，1-已对账 ", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="year", description="年份", required=false,type="integer", paramType="form", defaultValue="0" ),
        *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => 'FinStatement.update', 'uses' => 'FinStatementController@update']);

    /**
    * @SWG\Api(
    *     path="/api/fin-statement/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="fin-statement-delete",
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
    Route::delete('/{id}', ['as' => 'FinStatement.delete', 'uses' => 'FinStatementController@destroy']);

	/**
	 * @SWG\Api(
	 *     path="/api/fin-statement/customer/{customerId}",
	 *     @SWG\Operation(
	 *      method="GET",
	 *      nickname="fin-customer-show",
	 *      summary="经销商对账信息分页页面详情",
	 *      notes="经销商对账信息分页页面详情",
	 *      type="array",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="customerId", description="customerId", required=true, type="integer", paramType="path", defaultValue="1"),
	 *      )
	 *  )
	 * )
	 */
	Route::get('/customer/{customerId}', ['as' => 'FinStatement.customer', 'uses' => 'FinStatementController@customer']);

	/**
	 * @SWG\Api(
	 *     path="/api/fin-statement/pagination",
	 *     @SWG\Operation(
	 *      method="GET",
	 *      nickname="fin-pagination",
	 *      summary="分页信息",
	 *      notes="分页信息",
	 *      type="array",
	 *  )
	 * )
	 */
	Route::get('/pagination', ['as' => 'FinStatement.pagination', 'uses' => 'FinStatementController@pagination']);

});