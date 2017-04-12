<?php
/**
* @SWG\Resource(
*  resourcePath="/work-flow-task",
*  description="WorkFlowTask"
* )
*/
Route::group(['prefix' => 'work-flow-task', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/work-flow-task",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="work-flow-task-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:WorkFlowTask",
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
    Route::get('/', ['as' => 'WorkFlowTask.index', 'uses' => 'WorkFlowTaskController@index']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow-task/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="work-flow-task-show",
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
    Route::get('/{id}', ['as' => 'WorkFlowTask.show', 'uses' => 'WorkFlowTaskController@show']);

	/**
	 * @SWG\Api(
	 *     path="/api/work-flow-task/{id}/agree",
	 *     @SWG\Operation(
	 *      method="POST",
	 *      nickname="work-flow-task-agree",
	 *      summary="同意，审批通过",
	 *      notes="同意，审批通过",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="variables", description="变量（数组的json格式）", required=false,type="string", paramType="form", defaultValue="{&quot;store_change_list&quot;:{&quot;remark&quot;:&quot;同意，审批通过&quot;}}" ),
	 *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::post('/{id}/agree', ['as' => 'WorkFlowTask.agree', 'uses' => 'WorkFlowTaskController@agree']);

	/**
	 * @SWG\Api(
	 *     path="/api/work-flow-task/{id}/against",
	 *     @SWG\Operation(
	 *      method="POST",
	 *      nickname="work-flow-task-against",
	 *      summary="不同意，审批结束",
	 *      notes="不同意，审批结束",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="variables", description="变量（数组的json格式）", required=false,type="string", paramType="form", defaultValue="{&quot;store_change_list&quot;:{&quot;remark&quot;:&quot;同意，审批通过&quot;}}" ),
	 *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::post('/{id}/against', ['as' => 'WorkFlowTask.against', 'uses' => 'WorkFlowTaskController@against']);


});