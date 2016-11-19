<?php
/**
 * @SWG\Resource(
 *  resourcePath="/upgrade",
 *  description="apk升级"
 * )
 */
Route::group(['prefix' => 'upgrade', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/upgrade",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="upgrade-list",
     *      summary="apk 升级信息列表",
     *      notes="apk 升级信息列表",
     *      type="array",
     *     items="$ref:Upgrade",
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
    Route::get('/', ['as' => 'Upgrade.index', 'uses' => 'UpgradeController@index']);

    /**
     * @SWG\Api(
     *     path="/api/upgrade/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="upgrade-show",
     *      summary="apk 升级信息详情",
     *      notes="apk 升级信息详情",
     *      type="Upgrade",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'Upgrade.show', 'uses' => 'UpgradeController@show']);

    /**
     * @SWG\Api(
     *     path="/api/upgrade",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="upgrade-store",
     *      summary="新增apk 升级信息",
     *      notes="新增apk 升级信息",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="content", description="更新内容", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="enforce", description="是否强制（0-否， 1-是）", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="url", description="下载地址", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="version_code", description="version_code", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="version_name", description="version_name", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'Upgrade.store', 'uses' => 'UpgradeController@store']);

    /**
     * @SWG\Api(
     *     path="/api/upgrade/{id}",
     *     @SWG\Operation(
     *      method="PUT",
     *      nickname="upgrade-update",
     *      summary="apk 升级信息更新",
     *      notes="apk 升级信息更新",
     *      type="",
     *      @SWG\Parameters(
     *           @SWG\Parameter(name="content", description="更新内容", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="created_at", description="created_at", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="enforce", description="是否强制（0-否， 1-是）", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
                @SWG\Parameter(name="updated_at", description="updated_at", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="url", description="下载地址", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="version_code", description="version_code", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="version_name", description="version_name", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::put('/{id}', ['as' => 'Upgrade.update', 'uses' => 'UpgradeController@update']);

    /**
     * @SWG\Api(
     *     path="/api/upgrade/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="Upgrade-delete",
     *      summary="apk 升级信息删除",
     *      notes="apk 升级信息删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'Upgrade.delete', 'uses' => 'UpgradeController@destroy']);

});