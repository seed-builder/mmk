<?php
/**
 * @SWG\Resource(
 *  resourcePath="/visit-pzbz",
 *  description="拍照备注"
 * )
 */
Route::group(['prefix' => 'visit-pzbz', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/visit-pzbz",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-pzbz-list",
     *      summary="拍照备注列表",
     *      notes="拍照备注列表",
     *      type="array",
     *     items="$ref:VisitPzbz",
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
    Route::get('/', ['as' => 'VisitPzbz.index', 'uses' => 'VisitPzbzController@index']);

    /**
     * @SWG\Api(
     *     path="/api/visit-pzbz/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-pzbz-show",
     *      summary="拍照备注详情",
     *      notes="拍照备注详情",
     *      type="VisitPzbz",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'VisitPzbz.show', 'uses' => 'VisitPzbzController@show']);

    /**
     * @SWG\Api(
     *     path="/api/visit-pzbz",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-pzbz-store",
     *      summary="新增拍照备注",
     *      notes="新增拍照备注",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fbill_no", description="bill no", required=false,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="flog_id", description="visit_todo_calendar id", required=false,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fphoto_id", description="picture id", required=false,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fremark", description="备注", required=false,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'VisitPzbz.store', 'uses' => 'VisitPzbzController@store']);

    /**
     * @SWG\Api(
     *     path="/api/visit-pzbz/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-pzbz-update",
     *      summary="拍照备注更新",
     *      notes="拍照备注更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fbill_no", description="bill no", required=false,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="flog_id", description="visit_todo_calendar id", required=false,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fphoto_id", description="picture id", required=false,type="integer", paramType="form", defaultValue="0" ),
			    @SWG\Parameter(name="fremark", description="备注", required=false,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="id", description="", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'VisitPzbz.update', 'uses' => 'VisitPzbzController@update']);

    /**
     * @SWG\Api(
     *     path="/api/visit-pzbz/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="VisitPzbz-delete",
     *      summary="拍照备注删除",
     *      notes="拍照备注删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'VisitPzbz.delete', 'uses' => 'VisitPzbzController@destroy']);

});