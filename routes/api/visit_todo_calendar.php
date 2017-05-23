<?php
/**
 * @SWG\Resource(
 *  resourcePath="/visit-todo-calendar",
 *  description="巡访门店项目执行日历"
 * )
 */
Route::group(['prefix' => 'visit-todo-calendar', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/visit-todo-calendar",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-todo-calendar-list",
     *      summary="巡访门店项目日历列表",
     *      notes="巡访门店项目日历列表",
     *      type="array",
     *     items="$ref:VisitTodoCalendar",
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
    Route::get('/', ['as' => 'VisitTodoCalendar.index', 'uses' => 'VisitTodoCalendarController@index']);

    /**
     * @SWG\Api(
     *     path="/api/visit-todo-calendar/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-todo-calendar-show",
     *      summary="巡访门店项目日历详情",
     *      notes="巡访门店项目日历详情",
     *      type="VisitTodoCalendar",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'VisitTodoCalendar.show', 'uses' => 'VisitTodoCalendarController@show']);

    /**
     * @SWG\Api(
     *     path="/api/visit-todo-calendar/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-todo-calendar-update",
     *      summary="巡访门店项目日历更新",
     *      notes="巡访门店项目日历更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fstatus", description="巡访状态（1-未开始， 2-进行中， 3-已完成）", required=true,type="integer", paramType="form", defaultValue="1" ),
     *          @SWG\Parameter(name="flongitude", description="百度地图经度", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="flatitude", description="百度地图纬度", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="id", description="", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'VisitTodoCalendar.update', 'uses' => 'VisitTodoCalendarController@update']);

});