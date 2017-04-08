<?php
/**
* @SWG\Resource(
*  resourcePath="/work-flow-instance",
*  description="工作流实例"
* )
*/
Route::group(['prefix' => 'work-flow-instance', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/work-flow-instance",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="work-flow-instance-list",
    *      summary="工作流实例列表",
    *      notes="工作流实例列表",
    *      type="array",
    *     items="$ref:WorkFlowInstance",
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
    Route::get('/', ['as' => 'WorkFlowInstance.index', 'uses' => 'WorkFlowInstanceController@index']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow-instance/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="work-flow-instance-show",
    *      summary="工作流实例信息详情",
    *      notes="工作流实例信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'WorkFlowInstance.show', 'uses' => 'WorkFlowInstanceController@show']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow-instance",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="work-flow-instance-store",
    *      summary="新增工作流实例",
    *      notes="新增工作流实例",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="approver_id", description="审批人id（user id）", required=true,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="created_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="data_id", description="数据 id", required=true,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="data_type", description="数据表", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="node_id", description="当前所处审批节点", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="sponsor", description="发起人", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="sponsor_id", description="发起人id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="status", description="状态(0-审批中,1-结束)", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="title", description="标题", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="updated_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="work_flow_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'WorkFlowInstance.store', 'uses' => 'WorkFlowInstanceController@store']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow-instance/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="work-flow-instance-update",
    *      summary="更新工作流实例",
    *      notes="更新工作流实例",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="approver_id", description="审批人id（user id）", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="created_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="data_id", description="数据 id", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="data_type", description="数据表", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="node_id", description="当前所处审批节点", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="sponsor", description="发起人", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="sponsor_id", description="发起人id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="status", description="状态(0-审批中,1-结束)", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="title", description="标题", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="updated_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="work_flow_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'WorkFlowInstance.update', 'uses' => 'WorkFlowInstanceController@update']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow-instance/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="work-flow-instance-delete",
    *      summary="删除工作流实例",
    *      notes="删除工作流实例",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'WorkFlowInstance.delete', 'uses' => 'WorkFlowInstanceController@destroy']);

});