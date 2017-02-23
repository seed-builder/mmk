<?php
/**
* @SWG\Resource(
*  resourcePath="/display-policy-log",
*  description="签约门店陈列费用巡访日历"
* )
*/
Route::group(['prefix' => 'display-policy-log', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/display-policy-log",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="display-policy-log-list",
    *      summary="签约门店陈列费用巡访日历列表",
    *      notes="签约门店陈列费用巡访日历列表",
    *      type="array",
    *     items="$ref:DisplayPolicyLog",
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
    Route::get('/', ['as' => 'DisplayPolicyLog.index', 'uses' => 'DisplayPolicyLogController@index']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy-log/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="display-policy-log-show",
    *      summary="签约门店陈列费用巡访日历信息详情",
    *      notes="签约门店陈列费用巡访日历信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'DisplayPolicyLog.show', 'uses' => 'DisplayPolicyLogController@show']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy-log",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="display-policy-log-store",
    *      summary="新增签约门店陈列费用巡访日历",
    *      notes="新增签约门店陈列费用巡访日历",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fdate", description="拜访日期", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="femp_id", description="业务员id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="flog_id", description="visit_todo_calendar id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fphotos", description="图片id 集合， 逗号隔开", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fpolicy_id", description="方案id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fpolicy_store_id", description="签约门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fremark", description="备注", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'DisplayPolicyLog.store', 'uses' => 'DisplayPolicyLogController@store']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy-log/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="display-policy-log-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fdate", description="拜访日期", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="femp_id", description="业务员id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="flog_id", description="visit_todo_calendar id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fphotos", description="图片id 集合， 逗号隔开", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fpolicy_id", description="方案id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fpolicy_store_id", description="签约门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fremark", description="备注", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'DisplayPolicyLog.update', 'uses' => 'DisplayPolicyLogController@update']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy-log/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="display-policy-log-delete",
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
    Route::delete('/{id}', ['as' => 'DisplayPolicyLog.delete', 'uses' => 'DisplayPolicyLogController@destroy']);

});