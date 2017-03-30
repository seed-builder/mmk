<?php
/**
* @SWG\Resource(
*  resourcePath="/message",
*  description="Message"
* )
*/
Route::group(['prefix' => 'message', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/message",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="message-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:Message",
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
    Route::get('/', ['as' => 'Message.index', 'uses' => 'MessageController@index']);

    /**
    * @SWG\Api(
    *     path="/api/message/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="message-show",
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
    Route::get('/{id}', ['as' => 'Message.show', 'uses' => 'MessageController@show']);

    /**
    * @SWG\Api(
    *     path="/api/message",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="message-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fcreate_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="from_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="from_type", description="", required=false,type="string", paramType="form", defaultValue="" ),
                    *          @SWG\Parameter(name="message_content_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="read", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="to_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="to_type", description="", required=false,type="string", paramType="form", defaultValue="" ),
        *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'Message.store', 'uses' => 'MessageController@store']);

    /**
    * @SWG\Api(
    *     path="/api/message/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="message-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fcreate_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="from_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="from_type", description="", required=false,type="string", paramType="form", defaultValue="" ),
                    *          @SWG\Parameter(name="message_content_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="read", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="to_id", description="", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="to_type", description="", required=false,type="string", paramType="form", defaultValue="" ),
        *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'Message.update', 'uses' => 'MessageController@update']);

    /**
    * @SWG\Api(
    *     path="/api/message/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="message-delete",
    *      summary="删除",
    *      notes="删除",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'Message.delete', 'uses' => 'MessageController@destroy']);

});