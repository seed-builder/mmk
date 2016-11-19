<?php
/**
 * @SWG\Resource(
 *  resourcePath="/trip",
 *  description="出差"
 * )
 */
Route::group(['prefix' => 'trip', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/trip",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="trip-list",
     *      summary="出差列表",
     *      notes="出差列表",
     *      type="array",
     *     items="$ref:trip",
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
    Route::get('/', ['as' => 'trip.index', 'uses' => 'BusiTripController@index']);

    /**
     * @SWG\Api(
     *     path="/api/trip/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="trip-show",
     *      summary="出差详情",
     *      notes="出差详情",
     *      type="BusiTrip",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'trip.show', 'uses' => 'BusiTripController@show']);

    /**
     * @SWG\Api(
     *     path="/api/trip",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="trip-store",
     *      summary="新增出差",
     *      notes="新增出差",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="farrive_image", description="farrive_image", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="farrive_time", description="farrive_time", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fbillno", description="fbillno", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fdocument_status", description="fdocument_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="femp_id", description="femp_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="ffile_name", description="ffile_name", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ffile_path", description="ffile_path", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="flatitude", description="flatitude", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="flongitude", description="flongitude", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="forg_id", description="forg_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fout_time", description="fout_time", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fremark", description="fremark", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'trip.store', 'uses' => 'BusiTripController@store']);

    /**
     * @SWG\Api(
     *     path="/api/trip/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="trip-update",
     *      summary="出差更新",
     *      notes="出差更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="farrive_image", description="farrive_image", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="farrive_time", description="farrive_time", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fauditor_id", description="fauditor_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="faudit_date", description="faudit_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fbillno", description="fbillno", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcreate_date", description="fcreate_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcreator_id", description="fcreator_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdocument_status", description="fdocument_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="femp_id", description="femp_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="ffile_name", description="ffile_name", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ffile_path", description="ffile_path", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fforbidder_id", description="fforbidder_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fforbid_date", description="fforbid_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fforbid_status", description="fforbid_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="flatitude", description="flatitude", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="flongitude", description="flongitude", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmodify_date", description="fmodify_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmodify_id", description="fmodify_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="forg_id", description="forg_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fout_time", description="fout_time", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fremark", description="fremark", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'trip.update', 'uses' => 'BusiTripController@update']);

    /**
     * @SWG\Api(
     *     path="/api/trip/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="trip-delete",
     *      summary="出差删除",
     *      notes="出差删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'trip.delete', 'uses' => 'BusiTripController@destroy']);


});