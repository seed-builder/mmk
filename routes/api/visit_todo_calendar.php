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
     *     path="/api/visit-todo-calendar",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-todo-calendar-store",
     *      summary="新增巡访门店项目日历",
     *      notes="新增巡访门店项目日历",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fparent_id", description="父级id", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="fdate", description="日期", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="femp_id", description="员工id", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="fstatus", description="巡访状态（1-未开始， 2-进行中， 3-已完成）", required=true,type="integer", paramType="form", defaultValue="1" ),
     *          @SWG\Parameter(name="fstore_calendar_id", description="线路门店巡防日历id", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="ftodo_id", description="门店巡访项目id", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="flongitude", description="百度地图经度", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="flatitude", description="百度地图纬度", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'VisitTodoCalendar.store', 'uses' => 'VisitTodoCalendarController@store']);

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

    /**
     * @SWG\Api(
     *     path="/api/visit-todo-calendar/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="VisitTodoCalendar-delete",
     *      summary="巡访门店项目日历删除",
     *      notes="巡访门店项目日历删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'VisitTodoCalendar.delete', 'uses' => 'VisitTodoCalendarController@destroy']);

});