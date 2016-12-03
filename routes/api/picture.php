<?php
/**
 * @SWG\Resource(
 *  resourcePath="/picture",
 *  description="消息模板"
 * )
 */
Route::group(['prefix' => 'picture', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/picture",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="picture-list",
     *      summary="消息模板列表",
     *      notes="消息模板列表",
     *      type="array",
     *     items="$ref:Picture",
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
    Route::get('/', ['as' => 'Picture.index', 'uses' => 'PictureController@index']);

    /**
     * @SWG\Api(
     *     path="/api/picture/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="picture-show",
     *      summary="消息模板详情",
     *      notes="消息模板详情",
     *      type="Picture",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'Picture.show', 'uses' => 'PictureController@show']);

    /**
     * @SWG\Api(
     *     path="/api/picture",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="picture-store",
     *      summary="新增消息模板",
     *      notes="新增消息模板",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="link", description="链接地址", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="title", description="标题", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="type", description="类型，0-轮播图", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="url", description="图片地址", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'Picture.store', 'uses' => 'PictureController@store']);

    /**
     * @SWG\Api(
     *     path="/api/picture/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="picture-update",
     *      summary="消息模板更新",
     *      notes="消息模板更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="link", description="链接地址", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="title", description="标题", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="type", description="类型", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="url", description="图片地址", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="id", description="", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'Picture.update', 'uses' => 'PictureController@update']);

    /**
     * @SWG\Api(
     *     path="/api/picture/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="picture-delete",
     *      summary="消息模板删除",
     *      notes="消息模板删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'Picture.delete', 'uses' => 'PictureController@destroy']);


});