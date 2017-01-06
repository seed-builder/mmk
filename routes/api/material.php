<?php
/**
 * @SWG\Resource(
 *  resourcePath="/material",
 *  description="物料"
 * )
 */
Route::group(['prefix' => 'material', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/material",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="material-list",
     *      summary="物料列表",
     *      notes="物料列表",
     *      type="array",
     *     items="$ref:Material",
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
    Route::get('/', ['as' => 'Material.index', 'uses' => 'MaterialController@index']);

    /**
     * @SWG\Api(
     *     path="/api/material/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="material-show",
     *      summary="物料详情",
     *      notes="物料详情",
     *      type="Material",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'Material.show', 'uses' => 'MaterialController@show']);

    /**
     * @SWG\Api(
     *     path="/api/material",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="material-store",
     *      summary="新增物料",
     *      notes="新增物料",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fname", description="物料名称", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fnumber", description="物料编码", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="funit", description="单位", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'Material.store', 'uses' => 'MaterialController@store']);

    /**
     * @SWG\Api(
     *     path="/api/material/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="material-update",
     *      summary="物料更新",
     *      notes="物料更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fname", description="物料名称", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fnumber", description="物料编码", required=true,type="string", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="funit", description="单位", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'Material.update', 'uses' => 'MaterialController@update']);

    /**
     * @SWG\Api(
     *     path="/api/material/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="Material-delete",
     *      summary="物料删除",
     *      notes="物料删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'Material.delete', 'uses' => 'MaterialController@destroy']);

    
});