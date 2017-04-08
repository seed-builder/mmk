<?php
/**
* @SWG\Resource(
*  resourcePath="/work-flow",
*  description="工作流"
* )
*/
Route::group(['prefix' => 'work-flow', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/work-flow",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="work-flow-list",
    *      summary="工作流程列表",
    *      notes="工作流程列表",
    *      type="array",
    *     items="$ref:WorkFlow",
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
    Route::get('/', ['as' => 'WorkFlow.index', 'uses' => 'WorkFlowController@index']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="work-flow-show",
    *      summary="工作流程信息详情",
    *      notes="工作流程信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'WorkFlow.show', 'uses' => 'WorkFlowController@show']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="work-flow-store",
    *      summary="新增工作流程",
    *      notes="新增工作流程",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="created_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="desc", description="关联表名", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="email_template_id", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="msg_template_id", description="", required=true,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="name", description="名称", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="status", description="状态（0-未启用, 1-启用）", required=false,type="integer", paramType="form", defaultValue="1" ),
    *          @SWG\Parameter(name="updated_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'WorkFlow.store', 'uses' => 'WorkFlowController@store']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="work-flow-update",
    *      summary="更新工作流程",
    *      notes="更新工作流程",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="created_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="desc", description="关联表名", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="email_template_id", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="msg_template_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="name", description="名称", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="status", description="状态（0-未启用, 1-启用）", required=false,type="integer", paramType="form", defaultValue="1" ),
    *          @SWG\Parameter(name="updated_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'WorkFlow.update', 'uses' => 'WorkFlowController@update']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="work-flow-delete",
    *      summary="删除工作流程",
    *      notes="删除工作流程",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'WorkFlow.delete', 'uses' => 'WorkFlowController@destroy']);

});