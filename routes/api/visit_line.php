<?php
/**
 * @SWG\Resource(
 *  resourcePath="/visit-line",
 *  description="巡访线路"
 * )
 */
Route::group(['prefix' => 'visit-line', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/visit-line",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-line-list",
     *      summary="巡访线路列表",
     *      notes="巡访线路列表",
     *      type="array",
     *     items="$ref:VisitLine",
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
    Route::get('/', ['as' => 'VisitLine.index', 'uses' => 'VisitLineController@index']);

    /**
     * @SWG\Api(
     *     path="/api/visit-line/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-line-show",
     *      summary="巡访线路详情",
     *      notes="巡访线路详情",
     *      type="VisitLine",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'VisitLine.show', 'uses' => 'VisitLineController@show']);

    /**
     * @SWG\Api(
     *     path="/api/visit-line",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-line-store",
     *      summary="新增巡访线路",
     *      notes="新增巡访线路",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="femp_id", description="员工id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fname", description="名称", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="编号", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="forg_id", description="组织id", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'VisitLine.store', 'uses' => 'VisitLineController@store']);

    /**
     * @SWG\Api(
     *     path="/api/visit-line/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-line-update",
     *      summary="巡访线路更新",
     *      notes="巡访线路更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="femp_id", description="员工id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fname", description="名称", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="编号", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="forg_id", description="组织id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="id", description="", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'VisitLine.update', 'uses' => 'VisitLineController@update']);

    /**
     * @SWG\Api(
     *     path="/api/visit-line/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="VisitLine-delete",
     *      summary="巡访线路删除",
     *      notes="巡访线路删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'VisitLine.delete', 'uses' => 'VisitLineController@destroy']);

});