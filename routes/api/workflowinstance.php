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
	 *     path="/api/work-flow-instance/storeValid",
	 *     @SWG\Operation(
	 *      method="GET",
	 *      nickname="work-flow-instance-storeValid",
	 *      summary="门店是否在审批中",
	 *      notes="门店是否在审批中",
	 *      type="Attendance",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="store_id", description="门店id", required=true, type="integer", paramType="query", defaultValue="1"),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::get('/storeValid', ['as' => 'WorkFlowInstance.storeValid', 'uses' => 'WorkFlowInstanceController@storeValid']);


});