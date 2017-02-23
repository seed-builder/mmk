<?php
/**
 * @SWG\Resource(
 *  resourcePath="/display-policy-entry",
 *  description="陈列费用政策品项"
 * )
 */
Route::group(['prefix' => 'display-policy-entry', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/display-policy-entry",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="display-policy-entry-list",
     *      summary="陈列费用政策品项列表",
     *      notes="陈列费用政策品项列表",
     *      type="array",
     *     items="$ref:DisplayPolicyEntry",
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
    Route::get('/', ['as' => 'DisplayPolicyEntry.index', 'uses' => 'DisplayPolicyEntryController@index']);

    /**
     * @SWG\Api(
     *     path="/api/display-policy-entry/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="display-policy-entry-show",
     *      summary="陈列费用政策品项详情",
     *      notes="陈列费用政策品项详情",
     *      type="DisplayPolicyEntry",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'DisplayPolicyEntry.show', 'uses' => 'DisplayPolicyEntryController@show']);

    /**
     * @SWG\Api(
     *     path="/api/display-policy-entry",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="display-policy-entry-store",
     *      summary="新增陈列费用政策品项",
     *      notes="新增陈列费用政策品项",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fdisplay_policy_id", description="exp_display_policy id", required=true,type="integer", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fmaterail_id", description="exp_display_policy id", required=true,type="integer", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fmaterail_type", description="类型  0 正常产品 1 奖励产品 ", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'DisplayPolicyEntry.store', 'uses' => 'DisplayPolicyEntryController@store']);

    /**
     * @SWG\Api(
     *     path="/api/display-policy-entry/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="display-policy-entry-update",
     *      summary="陈列费用政策品项更新",
     *      notes="陈列费用政策品项更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fdisplay_policy_id", description="exp_display_policy id", required=true,type="integer", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fmaterail_id", description="exp_display_policy id", required=true,type="integer", paramType="form", defaultValue="" ),
			    @SWG\Parameter(name="fmaterail_type", description="类型  0 正常产品 1 奖励产品 ", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'DisplayPolicyEntry.update', 'uses' => 'DisplayPolicyEntryController@update']);

    /**
     * @SWG\Api(
     *     path="/api/display-policy-entry/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="DisplayPolicyEntry-delete",
     *      summary="陈列费用政策品项删除",
     *      notes="陈列费用政策品项删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'DisplayPolicyEntry.delete', 'uses' => 'DisplayPolicyEntryController@destroy']);

    
});