<?php
/**
* @SWG\Resource(
*  resourcePath="/display-policy",
*  description="DisplayPolicy"
* )
*/
Route::group(['prefix' => 'display-policy', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/display-policy",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="display-policy-list",
    *      summary="page list",
    *      notes="page list",
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
    Route::get('/{id}', ['as' => 'DisplayPolicy.show', 'uses' => 'DisplayPolicyController@show']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="display-policy-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbill_no", description="bill no", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcaption", description="陈列主题", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fcust_id", description="客户 id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdays", description="天数", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="数据状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="ffinish_date", description="执行结束日期 ", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="flog_id", description="visit_todo_calendar id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="frequire", description="陈列要求", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="freward_amount", description="奖励金额", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="freward_method", description="奖励方式", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstart_date", description="执行开始日期", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstatus", description="执行状态：0 未执行，1执行中 2已执行", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fstore_id", description="门店 id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fvalid_begin", description="有效期起", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fvalid_end", description="有效期止", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
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
    *      method="PUT",
    *      nickname="display-policy-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbill_no", description="bill no", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcaption", description="陈列主题", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fcust_id", description="客户 id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdays", description="天数", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="数据状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="ffinish_date", description="执行结束日期 ", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="flog_id", description="visit_todo_calendar id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="frequire", description="陈列要求", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="freward_amount", description="奖励金额", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="freward_method", description="奖励方式", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstart_date", description="执行开始日期", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstatus", description="执行状态：0 未执行，1执行中 2已执行", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fstore_id", description="门店 id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fvalid_begin", description="有效期起", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fvalid_end", description="有效期止", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'DisplayPolicy.update', 'uses' => 'DisplayPolicyController@update']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="display-policy-delete",
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
    Route::delete('/{id}', ['as' => 'DisplayPolicy.delete', 'uses' => 'DisplayPolicyController@destroy']);

});