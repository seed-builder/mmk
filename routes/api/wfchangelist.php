<?php
/**
* @SWG\Resource(
*  resourcePath="/wf-change-list",
*  description="变更单"
* )
*/
Route::group(['prefix' => 'wf-change-list', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/wf-change-list",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="wf-change-list-list",
    *      summary="变更单列表",
    *      notes="变更单列表",
    *      type="array",
    *     items="$ref:WfChangeList",
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
    Route::get('/', ['as' => 'WfChangeList.index', 'uses' => 'WfChangeListController@index']);

    /**
    * @SWG\Api(
    *     path="/api/wf-change-list/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="wf-change-list-show",
    *      summary="变更单信息详情",
    *      notes="变更单信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'WfChangeList.show', 'uses' => 'WfChangeListController@show']);

    /**
    * @SWG\Api(
    *     path="/api/wf-change-list",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="wf-change-list-store",
    *      summary="新增变更单",
    *      notes="新增变更单",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="data", description="数据json", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="数据状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="type", description="变更类型（0-新增， 1-更新， 2-删除）", required=false,type="string", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'WfChangeList.store', 'uses' => 'WfChangeListController@store']);

    /**
    * @SWG\Api(
    *     path="/api/wf-change-list/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="wf-change-list-update",
    *      summary="更新变更单",
    *      notes="更新变更单",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="data", description="数据json", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="数据状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="type", description="变更类型（0-新增， 1-更新， 2-删除）", required=false,type="string", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'WfChangeList.update', 'uses' => 'WfChangeListController@update']);

    /**
    * @SWG\Api(
    *     path="/api/wf-change-list/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="wf-change-list-delete",
    *      summary="删除变更单",
    *      notes="删除变更单",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'WfChangeList.delete', 'uses' => 'WfChangeListController@destroy']);

});