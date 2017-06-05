<?php
/**
 * @SWG\Resource(
 *  resourcePath="/visit-store-todo",
 *  description="巡访门店执行项目"
 * )
 */
Route::group(['prefix' => 'visit-store-todo', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/visit-store-todo",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-store-todo-list",
     *      summary="巡访门店执行项目列表",
     *      notes="巡访门店执行项目列表",
     *      type="array",
     *     items="$ref:VisitStoreTodo",
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
    Route::get('/', ['as' => 'VisitStoreTodo.index', 'uses' => 'VisitStoreTodoController@index']);

    /**
     * @SWG\Api(
     *     path="/api/visit-store-todo/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="visit-store-todo-show",
     *      summary="巡访门店执行项目详情",
     *      notes="巡访门店执行项目详情",
     *      type="VisitStoreTodo",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'VisitStoreTodo.show', 'uses' => 'VisitStoreTodoController@show']);

    /**
     * @SWG\Api(
     *     path="/api/visit-store-todo",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-store-todo-store",
     *      summary="新增巡访门店执行项目",
     *      notes="新增巡访门店执行项目",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="ffunction_number", description="定制功能编号", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fgroup_id", description="分组标识", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fis_must_visit", description="是否必巡", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="flag", description="标识符", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fname", description="名称", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="编号", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="forg_id", description="组织id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fparent_id", description="父级id", required=true,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'VisitStoreTodo.store', 'uses' => 'VisitStoreTodoController@store']);

    /**
     * @SWG\Api(
     *     path="/api/visit-store-todo/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="visit-store-todo-update",
     *      summary="巡访门店执行项目更新",
     *      notes="巡访门店执行项目更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="ffunction_number", description="定制功能编号", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fgroup_id", description="分组标识", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fis_must_visit", description="是否必巡", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="flag", description="标识符", required=true,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fname", description="名称", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fnumber", description="编号", required=true,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="forg_id", description="组织id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fparent_id", description="父级id", required=true,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="id", description="", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'VisitStoreTodo.update', 'uses' => 'VisitStoreTodoController@update']);

    /**
     * @SWG\Api(
     *     path="/api/visit-store-todo/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="VisitStoreTodo-delete",
     *      summary="巡访门店执行项目删除",
     *      notes="巡访门店执行项目删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'VisitStoreTodo.delete', 'uses' => 'VisitStoreTodoController@destroy']);

});