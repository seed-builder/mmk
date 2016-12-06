<?php
/**
 * @SWG\Resource(
 *  resourcePath="/visit-line-calendar",
 *  description="巡访线路日历"
 * )
 */
Route::group(['prefix' => 'visit-line-calendar', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/visit-line-calendar",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-line-calendar-list",
     *      summary="巡访线路日历列表",
     *      notes="巡访线路日历列表",
     *      type="array",
     *     items="$ref:VisitLineCalendar",
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
    Route::get('/', ['as' => 'VisitLineCalendar.index', 'uses' => 'VisitLineCalendarController@index']);

    /**
     * @SWG\Api(
     *     path="/api/visit-line-calendar/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-line-calendar-show",
     *      summary="巡访线路日历详情",
     *      notes="巡访线路日历详情",
     *      type="VisitLineCalendar",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'VisitLineCalendar.show', 'uses' => 'VisitLineCalendarController@show']);

    /**
     * @SWG\Api(
     *     path="/api/visit-line-calendar",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-line-calendar-store",
     *      summary="新增巡访线路日历",
     *      notes="新增巡访线路日历",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fdate", description="日期", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="femp_id", description="员工id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fline_id", description="线路id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="forg_id", description="组织id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fstatus", description="巡访状态（1-未开始， 2-进行中， 3-已完成）", required=true,type="integer", paramType="form", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'VisitLineCalendar.store', 'uses' => 'VisitLineCalendarController@store']);

    /**
     * @SWG\Api(
     *     path="/api/visit-line-calendar/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-line-calendar-update",
     *      summary="巡访线路日历更新",
     *      notes="巡访线路日历更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fstatus", description="巡访状态（1-未开始， 2-进行中， 3-已完成）", required=true,type="integer", paramType="form", defaultValue="1" ),
                @SWG\Parameter(name="id", description="", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'VisitLineCalendar.update', 'uses' => 'VisitLineCalendarController@update']);

    /**
     * @SWG\Api(
     *     path="/api/visit-line-calendar/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="VisitLineCalendar-delete",
     *      summary="巡访线路日历删除",
     *      notes="巡访线路日历删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'VisitLineCalendar.delete', 'uses' => 'VisitLineCalendarController@destroy']);


    /**
     * @SWG\Api(
     *     path="/api/visit-line-calendar/list",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-line-calendar-list",
     *      summary="获取一段日期内的巡访线路日历列表",
     *      notes="获取一段日期内的巡访线路日历列表",
     *      type="array",
     *     items="$ref:VisitLineCalendar",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="begin", description="开始日期", required=false, type="string", paramType="query", defaultValue="2016-12-05"),
     *          @SWG\Parameter(name="end", description="结束日期", required=false, type="string", paramType="query", defaultValue="2016-12-15"),
     *          @SWG\Parameter(name="femp_id", description="员工id", required=false, type="integer", paramType="query", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *    )
     * )
     */
    Route::get('/list', ['as' => 'VisitLineCalendar.getList', 'uses' => 'VisitLineCalendarController@getList']);


});