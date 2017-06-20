<?php
/**
 * @SWG\Resource(
 *  resourcePath="/organization",
 *  description="组织"
 * )
 */
Route::group(['prefix' => 'organization', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/organization",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="organization-list",
     *      summary="组织列表",
     *      notes="组织列表",
     *      type="array",
     *     items="$ref:organization",
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
    Route::get('/', ['as' => 'Organization.index', 'uses' => 'OrganizationController@index']);

    /**
     * @SWG\Api(
     *     path="/api/organization/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="organization-show",
     *      summary="组织详情",
     *      notes="组织详情",
     *      type="organization",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'Organization.show', 'uses' => 'OrganizationController@show']);

    /**
     * @SWG\Api(
     *     path="/api/organization",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="organization-store",
     *      summary="新增组织",
     *      notes="新增组织",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="faddress", description="faddress", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcontacts", description="fcontacts", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fdocument_status", description="fdocument_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="ffullname", description="ffullname", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fname", description="fname", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="fnumber", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fowner", description="fowner", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fphone", description="fphone", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'Organization.store', 'uses' => 'OrganizationController@store']);

    /**
     * @SWG\Api(
     *     path="/api/organization/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="organization-update",
     *      summary="组织更新",
     *      notes="组织更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="faddress", description="faddress", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fauditor_id", description="fauditor_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="faudit_date", description="faudit_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcontacts", description="fcontacts", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcreate_date", description="fcreate_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcreator_id", description="fcreator_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdocument_status", description="fdocument_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fforbidder_id", description="fforbidder_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fforbid_date", description="fforbid_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fforbid_status", description="fforbid_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="ffullname", description="ffullname", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmodify_date", description="fmodify_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmodify_id", description="fmodify_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fname", description="fname", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="fnumber", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fowner", description="fowner", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fphone", description="fphone", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'Organization.update', 'uses' => 'OrganizationController@update']);

    /**
     * @SWG\Api(
     *     path="/api/organization/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="organization-delete",
     *      summary="组织删除",
     *      notes="组织删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'Organization.delete', 'uses' => 'OrganizationController@destroy']);


});