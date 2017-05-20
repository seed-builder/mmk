<?php
/**
* @SWG\Resource(
*  resourcePath="/sys-config",
*  description="系统配置信息"
* )
*/
Route::group(['prefix' => 'sys-config', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/sys-config",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="sys-config-list",
    *      summary="系统配置信息列表",
    *      notes="系统配置信息列表",
    *      type="array",
    *     items="$ref:SysConfig",
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
    Route::get('/', ['as' => 'SysConfig.index', 'uses' => 'SysConfigController@index']);

    /**
	 * @SWG\Api(
	 *     path="/api/sys-config/{id}",
	 *     @SWG\Operation(
	 *      method="GET",
	 *      nickname="sys-config-show",
	 *      summary="系统配置信息详情",
	 *      notes="系统配置信息详情",
	 *      type="Attendance",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::get('/{id}', ['as' => 'SysConfig.show', 'uses' => 'SysConfigController@show']);

	/**
	 * @SWG\Api(
	 *     path="/api/sys-config/find/{name}",
	 *     @SWG\Operation(
	 *      method="GET",
	 *      nickname="sys-config-show",
	 *      summary="系统配置信息详情",
	 *      notes="系统配置信息详情",
	 *      type="Attendance",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="name", description="id", required=true, type="string", paramType="path", defaultValue="sale-variable"),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::get('/find/{name}', ['as' => 'SysConfig.find', 'uses' => 'SysConfigController@find']);

});