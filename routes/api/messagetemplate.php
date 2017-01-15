<?php
/**
* @SWG\Resource(
*  resourcePath="/message-template",
*  description="MessageTemplate"
* )
*/
Route::group(['prefix' => 'message-template'], function () {

    /**
    * @SWG\Api(
    *     path="/api/message-template",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="message-template-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:MessageTemplate",
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
    Route::get('/', ['as' => 'MessageTemplate.index', 'uses' => 'MessageTemplateController@index']);

    /**
    * @SWG\Api(
    *     path="/api/message-template/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="message-template-show",
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
    Route::get('/{id}', ['as' => 'MessageTemplate.show', 'uses' => 'MessageTemplateController@show']);

    /**
    * @SWG\Api(
    *     path="/api/message-template",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="message-template-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="content", description="内容模板，变量（#name）", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreate_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_date", description="", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="title", description="标题", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="type", description="消息模板类型： 0-jpush 推送", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'MessageTemplate.store', 'uses' => 'MessageTemplateController@store']);

    /**
    * @SWG\Api(
    *     path="/api/message-template/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="message-template-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="content", description="内容模板，变量（#name）", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreate_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_date", description="", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="title", description="标题", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="type", description="消息模板类型： 0-jpush 推送", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'MessageTemplate.update', 'uses' => 'MessageTemplateController@update']);

    /**
    * @SWG\Api(
    *     path="/api/message-template/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="message-template-delete",
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
    Route::delete('/{id}', ['as' => 'MessageTemplate.delete', 'uses' => 'MessageTemplateController@destroy']);

});