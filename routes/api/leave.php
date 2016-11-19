<?php
/**
 * @SWG\Resource(
 *  resourcePath="/leave",
 *  description="请假"
 * )
 */
Route::group(['prefix' => 'leave', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/leave",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="leave-list",
     *      summary="请假列表",
     *      notes="请假列表",
     *      type="array",
     *     items="$ref:leave",
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
    Route::get('/', ['as' => 'Leave.index', 'uses' => 'LeaveController@index']);

    /**
     * @SWG\Api(
     *     path="/api/leave/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="leave-show",
     *      summary="请假详情",
     *      notes="请假详情",
     *      type="leave",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'Leave.show', 'uses' => 'LeaveController@show']);

    /**
     * @SWG\Api(
     *     path="/api/leave",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="leave-store",
     *      summary="新增请假",
     *      notes="新增请假",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fask_type", description="fask_type", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fauditor_id", description="fauditor_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="faudit_date", description="faudit_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fbillno", description="fbillno", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcreate_date", description="fcreate_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcreator_id", description="fcreator_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdept_id", description="fdept_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdocument_status", description="fdocument_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="femp_id", description="femp_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fend_time", description="fend_time", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fforbidder_id", description="fforbidder_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fforbid_date", description="fforbid_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fforbid_status", description="fforbid_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="flentime", description="flentime", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fmodify_date", description="fmodify_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmodify_id", description="fmodify_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="forg_id", description="forg_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="freason", description="freason", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fremarks", description="fremarks", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fstart_time", description="fstart_time", required=false,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'Leave.store', 'uses' => 'LeaveController@store']);

    /**
     * @SWG\Api(
     *     path="/api/leave/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="leave-update",
     *      summary="请假更新",
     *      notes="请假更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fask_type", description="fask_type", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fauditor_id", description="fauditor_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="faudit_date", description="faudit_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fbillno", description="fbillno", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcreate_date", description="fcreate_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcreator_id", description="fcreator_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdept_id", description="fdept_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdocument_status", description="fdocument_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="femp_id", description="femp_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fend_time", description="fend_time", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fforbidder_id", description="fforbidder_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fforbid_date", description="fforbid_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fforbid_status", description="fforbid_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="flentime", description="flentime", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fmodify_date", description="fmodify_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmodify_id", description="fmodify_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="forg_id", description="forg_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="freason", description="freason", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fremarks", description="fremarks", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fstart_time", description="fstart_time", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'Leave.update', 'uses' => 'LeaveController@update']);

    /**
     * @SWG\Api(
     *     path="/api/leave/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="leave-delete",
     *      summary="请假删除",
     *      notes="请假删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'Leave.delete', 'uses' => 'LeaveController@destroy']);


});