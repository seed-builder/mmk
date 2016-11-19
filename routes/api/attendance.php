<?php
/**
 * @SWG\Resource(
 *  resourcePath="/attendance",
 *  description="考勤"
 * )
 */
Route::group(['prefix' => 'attendance', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/attendance",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="attendance-list",
     *      summary="考勤信息列表",
     *      notes="考勤信息列表",
     *      type="array",
     *     items="$ref:Attendance",
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
    Route::get('/', ['as' => 'Attendance.index', 'uses' => 'AttendanceController@index']);

    /**
     * @SWG\Api(
     *     path="/api/attendance/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="attendance-show",
     *      summary="考勤信息详情",
     *      notes="考勤信息详情",
     *      type="Attendance",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'Attendance.show', 'uses' => 'AttendanceController@show']);

    /**
     * @SWG\Api(
     *     path="/api/attendance",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="attendance-store",
     *      summary="新增考勤信息",
     *      notes="新增考勤信息",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="faddress", description="faddress", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="femp_id", description="femp_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="flatitude", description="flatitude", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="flongitude", description="flongitude", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmode", description="fmode", required=false,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="forg_id", description="forg_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fphoto", description="fphoto", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fremark", description="fremark", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftime", description="ftime", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftype", description="ftype", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'Attendance.store', 'uses' => 'AttendanceController@store']);

    /**
     * @SWG\Api(
     *     path="/api/attendance/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="attendance-update",
     *      summary="考勤信息更新",
     *      notes="考勤信息更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="faddress", description="faddress", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="femp_id", description="femp_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="flatitude", description="flatitude", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="flongitude", description="flongitude", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmode", description="fmode", required=false,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="forg_id", description="forg_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fphoto", description="fphoto", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fremark", description="fremark", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftime", description="ftime", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftype", description="ftype", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'Attendance.update', 'uses' => 'AttendanceController@update']);

    /**
     * @SWG\Api(
     *     path="/api/attendance/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="Attendance-delete",
     *      summary="考勤信息删除",
     *      notes="考勤信息删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'Attendance.delete', 'uses' => 'AttendanceController@destroy']);


});