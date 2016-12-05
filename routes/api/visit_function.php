<?php
/**
 * @SWG\Resource(
 *  resourcePath="/visit-function",
 *  description="定制功能"
 * )
 */
Route::group(['prefix' => 'visit-function', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/visit-function",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-function-list",
     *      summary="定制功能列表",
     *      notes="定制功能列表",
     *      type="array",
     *     items="$ref:VisitFunction",
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
    Route::get('/', ['as' => 'VisitFunction.index', 'uses' => 'VisitFunctionController@index']);

    /**
     * @SWG\Api(
     *     path="/api/visit-function/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-function-show",
     *      summary="定制功能详情",
     *      notes="定制功能详情",
     *      type="VisitFunction",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'VisitFunction.show', 'uses' => 'VisitFunctionController@show']);

    /**
     * @SWG\Api(
     *     path="/api/visit-function",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-function-store",
     *      summary="新增定制功能",
     *      notes="新增定制功能",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fname", description="名称", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="编号", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="forg_id", description="组织id", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'VisitFunction.store', 'uses' => 'VisitFunctionController@store']);

    /**
     * @SWG\Api(
     *     path="/api/visit-function/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-function-update",
     *      summary="定制功能更新",
     *      notes="定制功能更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fname", description="名称", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="编号", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="forg_id", description="组织id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="id", description="", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'VisitFunction.update', 'uses' => 'VisitFunctionController@update']);

    /**
     * @SWG\Api(
     *     path="/api/visit-function/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="VisitFunction-delete",
     *      summary="定制功能删除",
     *      notes="定制功能删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'VisitFunction.delete', 'uses' => 'VisitFunctionController@destroy']);

});