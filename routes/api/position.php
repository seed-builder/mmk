<?php
/**
 * @SWG\Resource(
 *  resourcePath="/position",
 *  description="职位信息"
 * )
 */
Route::group(['prefix' => 'position', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/position",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="position-list",
     *      summary="职位信息列表",
     *      notes="职位信息列表",
     *      type="array",
     *     items="$ref:Position",
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
    Route::get('/', ['as' => 'Position.index', 'uses' => 'PositionController@index']);

    /**
     * @SWG\Api(
     *     path="/api/position/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="position-show",
     *      summary="职位信息详情",
     *      notes="职位信息详情",
     *      type="Position",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'Position.show', 'uses' => 'PositionController@show']);

    /**
     * @SWG\Api(
     *     path="/api/position",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="position-store",
     *      summary="新增职位信息",
     *      notes="新增职位信息",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fdept_id", description="fdept_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fis_main", description="fis_main", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fname", description="fname", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="fnumber", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fparpost_id", description="fparpost_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fremark", description="fremark", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'Position.store', 'uses' => 'PositionController@store']);

    /**
     * @SWG\Api(
     *     path="/api/position/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="position-update",
     *      summary="职位信息更新",
     *      notes="职位信息更新",
     *      type="",
     *      @SWG\Parameters(     *
                @SWG\Parameter(name="fdept_id", description="fdept_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fis_main", description="fis_main", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fname", description="fname", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="fnumber", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fparpost_id", description="fparpost_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fremark", description="fremark", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'Position.update', 'uses' => 'PositionController@update']);

    /**
     * @SWG\Api(
     *     path="/api/position/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="Position-delete",
     *      summary="职位信息删除",
     *      notes="职位信息删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'Position.delete', 'uses' => 'PositionController@destroy']);

});