<?php
/**
* @SWG\Resource(
*  resourcePath="/permission",
*  description="Permission"
* )
*/
Route::group(['prefix' => 'permission', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/permission",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="permission-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:Permission",
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
    Route::get('/', ['as' => 'Permission.index', 'uses' => 'PermissionController@index']);

    /**
    * @SWG\Api(
    *     path="/api/permission/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="permission-show",
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
    Route::get('/{id}', ['as' => 'Permission.show', 'uses' => 'PermissionController@show']);

    /**
    * @SWG\Api(
    *     path="/api/permission",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="permission-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="created_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="description", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="display_name", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="name", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="updated_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'Permission.store', 'uses' => 'PermissionController@store']);

    /**
    * @SWG\Api(
    *     path="/api/permission/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="permission-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="created_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="description", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="display_name", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="name", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="updated_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'Permission.update', 'uses' => 'PermissionController@update']);

    /**
    * @SWG\Api(
    *     path="/api/permission/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="permission-delete",
    *      summary="删除",
    *      notes="删除",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'Permission.delete', 'uses' => 'PermissionController@destroy']);

});