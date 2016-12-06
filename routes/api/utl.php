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
     *              defaultValue="1bea3a3faa3838407eec786975f68335.jpeg"
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
     *              required=true,
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
	 *   path="/api/utl/upload-",
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
});