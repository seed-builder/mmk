<?php
/**
 * @SWG\Resource(
 *  resourcePath="/attendance-report",
 *  description="考勤报表"
 * )
 */
Route::group(['prefix' => 'attendance-report', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/attendance-report",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="attendance-report-list",
     *      summary="考勤报表信息列表",
     *      notes="考勤报表信息列表",
     *      type="array",
     *     items="$ref:AttendanceReport",
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
    Route::get('/', ['as' => 'AttendanceReport.index', 'uses' => 'AttendanceReportController@index']);

    /**
     * @SWG\Api(
     *     path="/api/attendance-report/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="attendance-report-show",
     *      summary="考勤报表信息详情",
     *      notes="考勤报表信息详情",
     *      type="AttendanceReport",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'AttendanceReport.show', 'uses' => 'AttendanceReportController@show']);

    /**
     * @SWG\Api(
     *     path="/api/attendance-report",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="attendance-report-store",
     *      summary="新增考勤报表信息",
     *      notes="新增考勤报表信息",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fabnormal_days", description="异常天数", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fmonth", description="月份", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fnormal_days", description="正常天数", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="femp_id", description="", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="forg_id", description="", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fwork_days", description="应打卡天数", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fyear", description="年份", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'AttendanceReport.store', 'uses' => 'AttendanceReportController@store']);

    /**
     * @SWG\Api(
     *     path="/api/attendance-report/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="attendance-report-update",
     *      summary="考勤报表信息更新",
     *      notes="考勤报表信息更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fabnormal_days", description="异常天数", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fmonth", description="月份", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fnormal_days", description="正常天数", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="femp_id", description="", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="forg_id", description="", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fwork_days", description="应打卡天数", required=true,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fyear", description="年份", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'AttendanceReport.update', 'uses' => 'AttendanceReportController@update']);

    /**
     * @SWG\Api(
     *     path="/api/attendance-report/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="AttendanceReport-delete",
     *      summary="考勤报表信息删除",
     *      notes="考勤报表信息删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'AttendanceReport.delete', 'uses' => 'AttendanceReportController@destroy']);


});