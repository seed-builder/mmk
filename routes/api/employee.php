<?php
/**
 * @SWG\Resource(
 *  resourcePath="/employee",
 *  description="员工"
 * )
 */
Route::group(['prefix' => 'employee', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/employee",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="employee-list",
     *      summary="员工列表",
     *      notes="员工列表",
     *      type="array",
     *     items="$ref:Employee",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="page", description="当前页", required=false, type="integer", paramType="query", defaultValue="1"),
     *          @SWG\Parameter(name="pageSize", description="页大小", required=false, type="integer", paramType="query", defaultValue="10"),
     *          @SWG\Parameter(name="sort", description="排序", required=false, type="string", paramType="query", defaultValue="id asc"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *    )
     * )
     */
    Route::get('/', ['as' => 'Employee.index', 'uses' => 'EmployeeController@index']);

    /**
     * @SWG\Api(
     *     path="/api/employee/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="employee-show",
     *      summary="员工详情",
     *      notes="员工详情",
     *      type="Employee",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=false, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'Employee.show', 'uses' => 'EmployeeController@show']);

    /**
     * @SWG\Api(
     *     path="/api/employee",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="employee-store",
     *      summary="新增员工",
     *      notes="新增员工",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="faddress", description="faddress", required=true,type="string", paramType="form", defaultValue="" ),     *
                @SWG\Parameter(name="fdept_id", description="fdept_id", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdocument_status", description="fdocument_status", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="femail", description="femail", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="femp_num", description="femp_num", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fname", description="fname", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="fnumber", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fpassword", description="fpassword", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fphone", description="fphone", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fphoto", description="fphoto", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fpost_id", description="fpost_id", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fremark", description="fremark", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'Employee.store', 'uses' => 'EmployeeController@store']);

    /**
     * @SWG\Api(
     *     path="/api/employee/{id}",
     *     @SWG\Operation(
     *      method="PUT",
     *      nickname="employee-update",
     *      summary="员工更新",
     *      notes="员工更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="faddress", description="faddress", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fauditor_id", description="fauditor_id", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="faudit_date", description="faudit_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcreate_date", description="fcreate_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcreator_id", description="fcreator_id", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdept_id", description="fdept_id", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdocument_status", description="fdocument_status", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="femail", description="femail", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="femp_num", description="femp_num", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fforbidder_id", description="fforbidder_id", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fforbid_date", description="fforbid_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fforbid_status", description="fforbid_status", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fmodify_date", description="fmodify_date", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmodify_id", description="fmodify_id", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fname", description="fname", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="fnumber", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fpassword", description="fpassword", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fphone", description="fphone", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fphoto", description="fphoto", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fpost_id", description="fpost_id", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fremark", description="fremark", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="id", description="id", required=true,type="string", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::put('/{id}', ['as' => 'Employee.update', 'uses' => 'EmployeeController@update']);

    /**
     * @SWG\Api(
     *     path="/api/employee/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="employee-delete",
     *      summary="员工删除",
     *      notes="员工删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'Employee.delete', 'uses' => 'EmployeeController@destroy']);

    /**
     * @SWG\Api(
     *   path="/api/employee/login",
     *   @SWG\Operation(
     *      method="POST",
     *      nickname="employee-login",
     *      summary="员工登陆",
     *      notes="员工登陆",
     *      type="Employee",
     *      @SWG\Parameters(
     *          @SWG\Parameter(
     *              name="phone",
     *              description="电话号码",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="1387777777"
     *          ),
     *          @SWG\Parameter(
     *              name="pwd",
     *              description="密码",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="123456"
     *          ),
     *          @SWG\Parameter(
     *              name="_sign",
     *              description="签名",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="09af6226a3643ea393622c67aedb9908"
     *          )
     *      ),
     *      @SWG\ResponseMessages(
     *          @SWG\ResponseMessage(code=401, message="签名验证错误！"),
     *          @SWG\ResponseMessage(code=200, message="成功。")
     *      )
     *   )
     * )
     */
    Route::post('/login', ['as' => 'EmployeeLogin', 'uses' => 'EmployeeController@login']);



});