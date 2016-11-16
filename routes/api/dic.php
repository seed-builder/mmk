<?php
/**
 * @SWG\Resource(
 *  resourcePath="/dic",
 *  description="字典表"
 * )
 */
Route::group(['prefix' => 'dic', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/dic",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="dic-list",
     *      summary="字典列表",
     *      notes="字典列表",
     *      type="array",
     *     items="$ref:Dic",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="type", description="类型", required=false, type="string", paramType="query", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *    )
     * )
     */
    Route::get('/', ['as' => 'Dic.index', 'uses' => 'DicController@index']);

    /**
     * @SWG\Api(
     *     path="/api/dic/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="dic-show",
     *      summary="字典详情",
     *      notes="字典详情",
     *      type="Dic",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'Dic.show', 'uses' => 'DicController@show']);

    /**
     * @SWG\Api(
     *     path="/api/dic",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="dic-store",
     *      summary="新增字典",
     *      notes="新增字典",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="type", description="类型", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="key", description="key", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="value", description="value", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'Dic.store', 'uses' => 'DicController@store']);

    /**
     * @SWG\Api(
     *     path="/api/dic/{id}",
     *     @SWG\Operation(
     *      method="PUT",
     *      nickname="dic-update",
     *      summary="字典更新",
     *      notes="字典更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="type", description="类型", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="key", description="key", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="value", description="value", required=true,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::put('/{id}', ['as' => 'Dic.update', 'uses' => 'DicController@update']);

    /**
     * @SWG\Api(
     *     path="/api/dic/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="dic-delete",
     *      summary="字典删除",
     *      notes="字典删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'Dic.delete', 'uses' => 'DicController@destroy']);


});