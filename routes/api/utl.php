<?php
/**
 * @SWG\Resource(
 *  resourcePath="/utl",
 *  description="公共"
 * )
 */
Route::group(['prefix' => 'utl', 'middleware' => 'api.sign'], function (){

    /**
     * @SWG\Api(
     *   path="/api/utl/upload-image",
     *   @SWG\Operation(
     *      method="POST",
     *      consumes={"multipart/form-data"},
     *      nickname="upload-image",
     *      summary="上传图片",
     *      notes="上传图片",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(
     *              name="imageFile",
     *              description="图片文件",
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
     *              paramType="form",
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
    Route::post('/upload-image', ['uses' => 'UtlController@uploadImage']);

    /**
     * @SWG\Api(
     *   path="/api/utl/show-image",
     *   @SWG\Operation(
     *      method="GET",
     *      nickname="show-image",
     *      summary="显示图片",
     *      notes="显示图片",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(
     *              name="imageId",
     *              description="图片文件id",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="1"
     *          ),
     *          @SWG\Parameter(
     *              name="h",
     *              description="高度",
     *              required=false,
     *              type="integer",
     *              paramType="query",
     *              defaultValue=""
     *          ),
     *          @SWG\Parameter(
     *              name="w",
     *              description="宽度",
     *              required=false,
     *              type="integer",
     *              paramType="query",
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
    Route::get('/show-image', ['uses' => 'UtlController@showImage']);

    /**
     * @SWG\Api(
     *   path="/api/utl/sync-db",
     *   @SWG\Operation(
     *      method="POST",
     *      nickname="sync-db",
     *      summary="同步数据表",
     *      notes="同步数据库表",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(
     *              name="table",
     *              description="表名",
     *              required=true,
     *              type="string",
     *              paramType="query",
     *              defaultValue="user"
     *          ),
     *          @SWG\Parameter(
     *              name="op",
     *              description="操作（0-新增， 1-修改， 2-删除, 3-删除所有",
     *              required=true,
     *              type="integer",
     *              paramType="query",
     *              defaultValue="0"
     *          ),
     *          @SWG\Parameter(
     *              name="data",
     *              description="json格式字符串",
     *              required=false,
     *              type="string",
     *              paramType="query",
     *              defaultValue="{id:1, name:'1234'}"
     *          ),
     *          @SWG\Parameter(
     *              name="_sign",
     *              description="签名",
     *              required=true,
     *              type="string",
     *              paramType="form",
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
    Route::post('/sync-db', ['uses' => 'UtlController@syncDB']);

	/**
	 * @SWG\Api(
	 *   path="/api/utl/upload-file",
	 *   @SWG\Operation(
	 *      method="POST",
	 *      consumes={"multipart/form-data"},
	 *      nickname="upload-image",
	 *      summary="上传文件",
	 *      notes="上传文件",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(
	 *              name="sourceFile",
	 *              description="文件",
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
	 *              paramType="form",
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
	Route::post('/upload-file', ['uses' => 'UtlController@uploadFile']);

	/**
	 * @SWG\Api(
	 *   path="/api/utl/download-file",
	 *   @SWG\Operation(
	 *      method="GET",
	 *      nickname="download-file",
	 *      summary="下载文件",
	 *      notes="下载文件",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(
	 *              name="id",
	 *              description="文件id",
	 *              required=true,
	 *              type="integer",
	 *              paramType="query",
	 *              defaultValue="12"
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
	Route::get('/download-file', ['uses' => 'UtlController@downloadFile']);

	/**
	 * @SWG\Api(
	 *   path="/api/utl/send-data",
	 *   @SWG\Operation(
	 *      method="POST",
	 *      consumes={"multipart/form-data"},
	 *      nickname="send-data",
	 *      summary="发送数据",
	 *      notes="发送数据",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(
	 *              name="table",
	 *              description="表名",
	 *              required=true,
	 *              type="string",
	 *              paramType="form",
	 *              defaultValue=""
	 *          ),
	 *          @SWG\Parameter(
	 *              name="op",
	 *              description="操作（0-add, 1-update, 2-delete）",
	 *              required=true,
	 *              type="integer",
	 *              paramType="form",
	 *              defaultValue=""
	 *          ),
	 *          @SWG\Parameter(
	 *              name="condition",
	 *              description="条件（1=1）",
	 *              required=true,
	 *              type="string",
	 *              paramType="form",
	 *              defaultValue="1=1"
	 *          ),
	 *          @SWG\Parameter(
	 *              name="_sign",
	 *              description="签名",
	 *              required=true,
	 *              type="string",
	 *              paramType="form",
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
	Route::post('/send-data', ['uses' => 'UtlController@sendData']);

	/**
	 * @SWG\Api(
	 *   path="/api/utl/sms-verify",
	 *   @SWG\Operation(
	 *      method="POST",
	 *      consumes={"multipart/form-data"},
	 *      nickname="sms-verify",
	 *      summary="发送验证码短信",
	 *      notes="发送验证码短信",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(
	 *              name="phone",
	 *              description="手机号",
	 *              required=true,
	 *              type="string",
	 *              paramType="form",
	 *              defaultValue=""
	 *          ),
	 *          @SWG\Parameter(
	 *              name="_sign",
	 *              description="签名",
	 *              required=true,
	 *              type="string",
	 *              paramType="form",
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
	Route::post('/sms-verify', ['uses' => 'UtlController@sendVerifyCode']);

	/**
	 * @SWG\Api(
	 *   path="/api/utl/check-verify",
	 *   @SWG\Operation(
	 *      method="POST",
	 *      consumes={"multipart/form-data"},
	 *      nickname="check-verify",
	 *      summary="判断验证码是否正确",
	 *      notes="判断验证码是否正确",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(
	 *              name="phone",
	 *              description="手机号",
	 *              required=true,
	 *              type="string",
	 *              paramType="form",
	 *              defaultValue=""
	 *          ),
	 *          @SWG\Parameter(
	 *              name="code",
	 *              description="验证码",
	 *              required=true,
	 *              type="string",
	 *              paramType="form",
	 *              defaultValue=""
	 *          ),
	 *          @SWG\Parameter(
	 *              name="_sign",
	 *              description="签名",
	 *              required=true,
	 *              type="string",
	 *              paramType="form",
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
	Route::post('/check-verify', ['uses' => 'UtlController@checkVerifyCode']);

	/**
	 * @SWG\Api(
	 *   path="/api/utl/get-cust-amount/{cust_id}",
	 *   @SWG\Operation(
	 *      method="GET",
	 *      nickname="get-cust-amount",
	 *      summary="获取经销商账款余额",
	 *      notes="获取经销商账款余额",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(
	 *              name="cust_id",
	 *              description="经销商id",
	 *              required=true,
	 *              type="integer",
	 *              paramType="path",
	 *              defaultValue="293095"
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
	Route::get('/get-cust-amount/{cust_id}', ['uses' => 'UtlController@getCustAmount']);

	/**
	 * @SWG\Api(
	 *   path="/api/utl/push-message/{user_id}",
	 *   @SWG\Operation(
	 *      method="POST",
	 *      nickname="get-cust-amount",
	 *      summary="极光推送消息",
	 *      notes="极光推送消息",
	 *      type="",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(
	 *              name="user_id",
	 *              description="用户id",
	 *              required=true,
	 *              type="integer",
	 *              paramType="path",
	 *              defaultValue="463"
	 *          ),
	 *          @SWG\Parameter(
	 *              name="type",
	 *              description="type(1-考勤提醒, 2-到货确认)",
	 *              required=true,
	 *              type="integer",
	 *              paramType="query",
	 *              defaultValue="1"
	 *          ),
	 *          @SWG\Parameter(
	 *              name="title",
	 *              description="标题",
	 *              required=true,
	 *              type="string",
	 *              paramType="query",
	 *              defaultValue="标题"
	 *          ),
	 *         @SWG\Parameter(
	 *              name="msg",
	 *              description="内容",
	 *              required=true,
	 *              type="string",
	 *              paramType="query",
	 *              defaultValue="内容"
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
	Route::post('/push-message/{user_id}', ['uses' => 'UtlController@pushMessage']);

});