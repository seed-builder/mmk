<?php
/**
* @SWG\Resource(
*  resourcePath="/work-flow-log",
*  description="工作流实例审批日志"
* )
*/
Route::group(['prefix' => 'work-flow-log', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/work-flow-log",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="work-flow-log-list",
    *      summary="工作流实例审批日志列表",
    *      notes="工作流实例审批日志列表",
    *      type="array",
    *     items="$ref:WorkFlowLog",
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
    Route::get('/', ['as' => 'WorkFlowLog.index', 'uses' => 'WorkFlowLogController@index']);

    /**
    * @SWG\Api(
    *     path="/api/work-flow-log/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="work-flow-log-show",
    *      summary="工作流实例审批日志信息详情",
    *      notes="工作流实例审批日志信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'WorkFlowLog.show', 'uses' => 'WorkFlowLogController@show']);

	/**
	 * @SWG\Api(
	 *     path="/api/work-flow-log/{id}/agree",
	 *     @SWG\Operation(
	 *      method="PUT",
	 *      nickname="work-flow-log-agree",
	 *      summary="同意，审批通过",
	 *      notes="同意，审批通过",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::put('/{id}/agree', ['as' => 'WorkFlowLogController.agree', 'uses' => 'WorkFlowLogController@agree']);

	/**
	 * @SWG\Api(
	 *     path="/api/work-flow-log/{id}/against",
	 *     @SWG\Operation(
	 *      method="PUT",
	 *      nickname="work-flow-log-against",
	 *      summary="不同意，审批结束",
	 *      notes="不同意，审批结束",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::put('/{id}/against', ['as' => 'WorkFlowLogController.against', 'uses' => 'WorkFlowLogController@against']);


});