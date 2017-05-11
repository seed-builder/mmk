<?php
/**
* @SWG\Resource(
*  resourcePath="/rollcall",
*  description="Rollcall - 实时点名报表"
* )
*/
Route::group(['prefix' => 'rollcall', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/rollcall",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="rollcall-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:Rollcall",
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
    Route::get('/', ['as' => 'Rollcall.index', 'uses' => 'RollcallController@index']);

    /**
    * @SWG\Api(
    *     path="/api/rollcall/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="rollcall-show",
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
    Route::get('/{id}', ['as' => 'Rollcall.show', 'uses' => 'RollcallController@show']);

});