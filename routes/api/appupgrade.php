<?php
/**
* @SWG\Resource(
*  resourcePath="/app-upgrade",
*  description="AppUpgrade"
* )
*/
Route::group(['prefix' => 'app-upgrade'], function () {

    /**
    * @SWG\Api(
    *     path="/api/app-upgrade",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="app-upgrade-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:AppUpgrade",
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
    Route::get('/', ['as' => 'AppUpgrade.index', 'uses' => 'AppUpgradeController@index']);

    /**
    * @SWG\Api(
    *     path="/api/app-upgrade/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="app-upgrade-show",
    *      summary="信息详情",
    *      notes="信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'AppUpgrade.show', 'uses' => 'AppUpgradeController@show']);

    /**
    * @SWG\Api(
    *     path="/api/app-upgrade",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="app-upgrade-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="content", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="created_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="enforce", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="updated_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="upgrade_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="url", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="version_code", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="version_name", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'AppUpgrade.store', 'uses' => 'AppUpgradeController@store']);

    /**
    * @SWG\Api(
    *     path="/api/app-upgrade/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="app-upgrade-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="content", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="created_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="enforce", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="updated_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="upgrade_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="url", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="version_code", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="version_name", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'AppUpgrade.update', 'uses' => 'AppUpgradeController@update']);

    /**
    * @SWG\Api(
    *     path="/api/app-upgrade/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="app-upgrade-delete",
    *      summary="删除",
    *      notes="删除",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'AppUpgrade.delete', 'uses' => 'AppUpgradeController@destroy']);

});