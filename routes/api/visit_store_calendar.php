<?php
/**
 * @SWG\Resource(
 *  resourcePath="/visit-store-calendar",
 *  description="巡访线路门店"
 * )
 */
Route::group(['prefix' => 'visit-store-calendar', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/visit-store-calendar",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-store-calendar-list",
     *      summary="巡访线路门店日历列表",
     *      notes="巡访线路门店日历列表",
     *      type="array",
     *     items="$ref:VisitStoreCalendar",
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
    Route::get('/', ['as' => 'VisitStoreCalendar.index', 'uses' => 'VisitStoreCalendarController@index']);

    /**
     * @SWG\Api(
     *     path="/api/visit-store-calendar/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-store-calendar-show",
     *      summary="巡访线路门店日历详情",
     *      notes="巡访线路门店日历详情",
     *      type="VisitStoreCalendar",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'VisitStoreCalendar.show', 'uses' => 'VisitStoreCalendarController@show']);

    /**
     * @SWG\Api(
     *     path="/api/visit-store-calendar",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-store-calendar-store",
     *      summary="新增巡访线路门店日历",
     *      notes="新增巡访线路门店日历",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fdate", description="日期", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fleader_id", description="员工上级id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="femp_id", description="员工id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fline_calendar_id", description="线路巡防日历id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="forg_id", description="组织id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fstatus", description="巡访状态（1-未开始， 2-进行中， 3-已完成）", required=true,type="integer", paramType="form", defaultValue="1" ),
                @SWG\Parameter(name="fstore_id", description="门店id", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'VisitStoreCalendar.store', 'uses' => 'VisitStoreCalendarController@store']);

    /**
     * @SWG\Api(
     *     path="/api/visit-store-calendar/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-store-calendar-update",
     *      summary="巡访线路门店日历更新",
     *      notes="巡访线路门店日历更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fstatus", description="巡访状态（1-未开始， 2-进行中， 3-已完成）", required=true,type="integer", paramType="form", defaultValue="1" ),
                @SWG\Parameter(name="id", description="", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'VisitStoreCalendar.update', 'uses' => 'VisitStoreCalendarController@update']);

    /**
     * @SWG\Api(
     *     path="/api/visit-store-calendar/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="VisitStoreCalendar-delete",
     *      summary="巡访线路门店日历删除",
     *      notes="巡访线路门店日历删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'VisitStoreCalendar.delete', 'uses' => 'VisitStoreCalendarController@destroy']);

});