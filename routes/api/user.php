<?php
/**
* @SWG\Resource(
*  resourcePath="/user",
*  description="User"
* )
*/
Route::group(['prefix' => 'user', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/user",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="user-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:User",
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
    Route::get('/', ['as' => 'User.index', 'uses' => 'UserController@index']);

    /**
    * @SWG\Api(
    *     path="/api/user/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="user-show",
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
    Route::get('/{id}', ['as' => 'User.show', 'uses' => 'UserController@show']);

    /**
    * @SWG\Api(
    *     path="/api/user",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="user-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="created_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="email", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="name", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="password", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="remember_token", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="updated_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'User.store', 'uses' => 'UserController@store']);

    /**
    * @SWG\Api(
    *     path="/api/user/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="user-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="created_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="email", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="name", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="password", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="remember_token", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="updated_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => 'User.update', 'uses' => 'UserController@update']);

    /**
    * @SWG\Api(
    *     path="/api/user/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="user-delete",
    *      summary="删除",
    *      notes="删除",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'User.delete', 'uses' => 'UserController@destroy']);

	/**
	 * @SWG\Api(
	 *   path="/api/user/login",
	 *   @SWG\Operation(
	 *      method="POST",
	 *      nickname="user-login",
	 *      summary="用户登陆",
	 *      notes="用户登陆",
	 *      type="User",
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
	 *              name="password",
	 *              description="密码",
	 *              required=true,
	 *              type="string",
	 *              paramType="query",
	 *              defaultValue="123456"
	 *          ),
	 *         @SWG\Parameter(
	 *              name="type",
	 *              description="类型(employee--员工, customer--经销商)",
	 *              required=true,
	 *              type="string",
	 *              paramType="query",
	 *              defaultValue="customer"
	 *          ),
     *          @SWG\Parameter(
     *              name="device_sn",
     *              description="设备号",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="asdafdasd"
     *          ),
     *          @SWG\Parameter(
     *              name="device",
     *              description="设备（android, iphone）",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="asdafdasd"
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
	Route::post('/login', ['as' => 'User.Login', 'uses' => 'UserController@login']);

	//changePwd
	/**
	 * @SWG\Api(
	 *     path="/api/user/change-pwd",
	 *     @SWG\Operation(
	 *      method="POST",
	 *      nickname="change-pwd",
	 *      summary="修改密码",
	 *      notes="修改密码",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="phone", description="手机号", required=true,type="string", paramType="form", defaultValue="" ),
				@SWG\Parameter(name="password", description="密码", required=true,type="string", paramType="form", defaultValue="" ),
				@SWG\Parameter(name="code", description="验证码", required=true,type="string", paramType="form", defaultValue="" ),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::post('/change-pwd', ['as' => 'User.changePwd', 'uses' => 'UserController@changePwd']);


});