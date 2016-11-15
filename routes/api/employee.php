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
     *   path="/api/employee/login/{phone}",
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
     *              paramType="path",
     *              defaultValue="1387777777"
     *          ),
     *          @SWG\Parameter(
     *              name="pwd",
     *              description="密码",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="****"
     *          ),
     *          @SWG\Parameter(
     *              name="_sign",
     *              description="签名",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="****"
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