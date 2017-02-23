<?php
/**
 * @SWG\Resource(
 *  resourcePath="/display-policy",
 *  description="陈列信息"
 * )
 */
Route::group(['prefix' => 'display-policy', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/display-policy",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="display-policy-list",
     *      summary="陈列费用政策信息列表",
     *      notes="陈列费用政策信息列表",
     *      type="array",
     *     items="$ref:DisplayPolicy",
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
    Route::get('/', ['as' => 'DisplayPolicy.index', 'uses' => 'DisplayPolicyController@index']);

    /**
     * @SWG\Api(
     *     path="/api/display-policy/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="display-policy-show",
     *      summary="陈列费用政策信息详情",
     *      notes="陈列费用政策信息详情",
     *      type="DisplayPolicy",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'DisplayPolicy.show', 'uses' => 'DisplayPolicyController@show']);

    /**
     * @SWG\Api(
     *     path="/api/display-policy",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="display-policy-store",
     *      summary="新增陈列费用政策信息",
     *      notes="新增陈列费用政策信息",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fbill_no", description="bill no", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fcaption", description="陈列主题", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fcust_id", description="客户 id", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fdays", description="天数", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="ffinish_date", description="执行结束日期 ", required=false,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="flog_id", description="visit_todo_calendar id", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="forg_id", description="组织id", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="frequire", description="陈列要求", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="freward_amount", description="奖励金额", required=true,type="string", paramType="form", defaultValue="0.00" ),
			    @SWG\Parameter(name="freward_method", description="奖励方式", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fstart_date", description="执行开始日期", required=false,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fstatus", description="执行状态：0 未执行，1执行中 2已执行", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fstore_id", description="门店 id", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fvalid_begin", description="有效期起", required=false,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fvalid_end", description="有效期止", required=false,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'DisplayPolicy.store', 'uses' => 'DisplayPolicyController@store']);

    /**
     * @SWG\Api(
     *     path="/api/display-policy/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="display-policy-update",
     *      summary="陈列费用政策信息更新",
     *      notes="陈列费用政策信息更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fbill_no", description="bill no", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fcaption", description="陈列主题", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fcust_id", description="客户 id", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fdays", description="天数", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="ffinish_date", description="执行结束日期 ", required=false,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="flog_id", description="visit_todo_calendar id", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="forg_id", description="组织id", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="frequire", description="陈列要求", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="freward_amount", description="奖励金额", required=true,type="string", paramType="form", defaultValue="0.00" ),
			    @SWG\Parameter(name="freward_method", description="奖励方式", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fstart_date", description="执行开始日期", required=false,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fstatus", description="执行状态：0 未执行，1执行中 2已执行", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fstore_id", description="门店 id", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fvalid_begin", description="有效期起", required=false,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fvalid_end", description="有效期止", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'DisplayPolicy.update', 'uses' => 'DisplayPolicyController@update']);

    /**
     * @SWG\Api(
     *     path="/api/display-policy/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="DisplayPolicy-delete",
     *      summary="陈列费用政策信息删除",
     *      notes="陈列费用政策信息删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'DisplayPolicy.delete', 'uses' => 'DisplayPolicyController@destroy']);

    
});