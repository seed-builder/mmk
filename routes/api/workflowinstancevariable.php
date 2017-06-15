<?php
/**
* @SWG\Resource(
*  resourcePath="/work-flow-instance-variable",
*  description="工作流实例变量"
* )
*/
Route::group(['prefix' => 'work-flow-instance-variable', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/work-flow-instance-variable",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="work-flow-instance-variable-list",
    *      summary="工作流实例变量列表",
    *      notes="工作流实例变量列表",
    *      type="array",
    *     items="$ref:WorkFlowInstanceVariable",
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
    Route::get('/', ['as' => 'WorkFlowInstanceVariable.index', 'uses' => 'WorkFlowInstanceVariableController@index']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow-instance-variable/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="work-flow-instance-variable-show",
    *      summary="工作流实例变量详情",
    *      notes="工作流实例变量详情",
    *      type="WorkFlowInstanceVariable",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'WorkFlowInstanceVariable.show', 'uses' => 'WorkFlowInstanceVariableController@show']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow-instance-variable/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="work-flow-instance-variable-update",
    *      summary="更新工作流实例变量",
    *      notes="更新工作流实例变量",
    *      type="WorkFlowInstanceVariable",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="created_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
                    *          @SWG\Parameter(name="name", description="变量名（英文）", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="uid", description="guid", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="updated_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="value", description="变量值", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="work_flow_instance_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="work_flow_variable_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
        *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => 'WorkFlowInstanceVariable.update', 'uses' => 'WorkFlowInstanceVariableController@update']);


});