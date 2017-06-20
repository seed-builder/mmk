<?php
/**
 * @SWG\Resource(
 *  resourcePath="/department",
 *  description="部门"
 * )
 */
Route::group(['prefix' => 'department', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/department",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="department-list",
     *      summary="部门列表",
     *      notes="部门列表",
     *      type="array",
     *     items="$ref:Department",
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
    Route::get('/', ['as' => 'Department.index', 'uses' => 'DepartmentController@index']);

    /**
     * @SWG\Api(
     *     path="/api/department/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="Department-show",
     *      summary="部门详情",
     *      notes="部门详情",
     *      type="Department",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'Department.show', 'uses' => 'DepartmentController@show']);

    /**
     * @SWG\Api(
     *     path="/api/department",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="department-store",
     *      summary="新增部门",
     *      notes="新增部门",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fdocument_status", description="fdocument_status", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="ffullname", description="ffullname", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fname", description="fname", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="fnumber", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fpardept_id", description="fpardept_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fremark", description="fremark", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'Department.store', 'uses' => 'DepartmentController@store']);

    /**
     * @SWG\Api(
     *     path="/api/department/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="department-update",
     *      summary="部门更新",
     *      notes="部门更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="fauditor_id", description="fauditor_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="faudit_date", description="faudit_date", required=false,type="string", paramType="form", defaultValue="" ),
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
                @SWG\Parameter(name="fpardept_id", description="fpardept_id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fremark", description="fremark", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'Department.update', 'uses' => 'DepartmentController@update']);

    /**
     * @SWG\Api(
     *     path="/api/department/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="department-delete",
     *      summary="部门删除",
     *      notes="部门删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'Department.delete', 'uses' => 'DepartmentController@destroy']);


});