<?php
/**
* @SWG\Resource(
*  resourcePath="/channel-group",
*  description="ChannelGroup"
* )
*/
Route::group(['prefix' => 'channel-group'], function () {

    /**
    * @SWG\Api(
    *     path="/api/channel-group",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="channel-group-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:ChannelGroup",
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
    Route::get('/', ['as' => 'ChannelGroup.index', 'uses' => 'ChannelGroupController@index']);

    /**
    * @SWG\Api(
    *     path="/api/channel-group/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="channel-group-show",
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
    Route::get('/{id}', ['as' => 'ChannelGroup.show', 'uses' => 'ChannelGroupController@show']);

    /**
    * @SWG\Api(
    *     path="/api/channel-group",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="channel-group-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="数据状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fname", description="分组名称", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fnumber", description="分组编码", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fparent_id", description="分组上级", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsort", description="排序", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="ftype", description="分组类型", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'ChannelGroup.store', 'uses' => 'ChannelGroupController@store']);

    /**
    * @SWG\Api(
    *     path="/api/channel-group/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="channel-group-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="数据状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fname", description="分组名称", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fnumber", description="分组编码", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fparent_id", description="分组上级", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsort", description="排序", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="ftype", description="分组类型", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'ChannelGroup.update', 'uses' => 'ChannelGroupController@update']);

    /**
    * @SWG\Api(
    *     path="/api/channel-group/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="channel-group-delete",
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
    Route::delete('/{id}', ['as' => 'ChannelGroup.delete', 'uses' => 'ChannelGroupController@destroy']);

});