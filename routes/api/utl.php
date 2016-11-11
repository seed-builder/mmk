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
     *              description="图片文件",
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
});