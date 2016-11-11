<?php
/**
 * @SWG\Resource(
 *  resourcePath="/user",
 *  description="用户"
 * )
 */
Route::group(['prefix' => 'user', 'middleware' => 'api.sign'], function (){
    /**
     * @SWG\Api(
     *   path="/api/user/list",
     *   @SWG\Operation(
     *      method="GET",
     *      nickname="UserList",
     *      summary="用户列表",
     *      notes="获取用户列表",
     *      type="User",
     *      @SWG\Parameters(
     *          @SWG\Parameter(
     *              name="page",
     *              description="页码",
     *              required=false,
     *              type="integer",
     *              paramType="query",
     *              defaultValue="1"
     *          ),
     *          @SWG\Parameter(
     *              name="limit",
     *              description="每页数",
     *              required=false,
     *              type="integer",
     *              paramType="query",
     *              defaultValue="15"
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
    Route::get('/list', ['as' => 'UserList', 'uses' => 'UserController@index']);

    /**
     * @SWG\Api(
     *   path="/api/user/login",
     *   @SWG\Operation(
     *      method="GET",
     *      nickname="UserList",
     *      summary="用户登陆",
     *      notes="用户登陆",
     *      type="User",
     *      @SWG\Parameters(
     *          @SWG\Parameter(
     *              name="pwd",
     *              description="密码",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="123456"
     *          ),
     *          @SWG\Parameter(
     *              name="name",
     *              description="用户名",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="john"
     *          ),
     *          @SWG\Parameter(
     *              name="testfile",
     *              description="testfile",
     *              required=true,
     *              type="file",
     *              paramType="form",
     *              defaultValue=""
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
    Route::get('/login', ['as' => 'UserLogin', 'uses' => 'UserController@login']);

});