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


});