<?php
/**
* @SWG\Resource(
*  resourcePath="/material",
*  description="物料（商品）"
* )
*/
Route::group(['prefix' => 'material', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/material",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="material-list",
    *      summary="物料（商品）列表",
    *      notes="物料（商品）列表",
    *      type="array",
    *     items="$ref:Material",
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
    Route::get('/', ['as' => 'Material.index', 'uses' => 'MaterialController@index']);

    /**
    * @SWG\Api(
    *     path="/api/material/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="material-show",
    *      summary="物料（商品）信息详情",
    *      notes="物料（商品）信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'Material.show', 'uses' => 'MaterialController@show']);

    /**
    * @SWG\Api(
    *     path="/api/material",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="material-store",
    *      summary="新增物料（商品）",
    *      notes="新增物料（商品）",
    *      type="",
    *      @SWG\Parameters(
    *
    *          @SWG\Parameter(name="fname", description="物料名称", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fnumber", description="物料编码", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fsale_unit", description="销售单位", required=false,type="string", paramType="form", defaultValue="箱" ),
    *          @SWG\Parameter(name="fbase_unit", description="基本单位", required=false,type="string", paramType="form", defaultValue="瓶" ),
    *          @SWG\Parameter(name="fratio", description="换算成销售单位乘数", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fspecification", description="规格", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'Material.store', 'uses' => 'MaterialController@store']);

    /**
    * @SWG\Api(
    *     path="/api/material/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="material-update",
    *      summary="更新物料（商品）",
    *      notes="更新物料（商品）",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fbase_unit", description="基本单位", required=false,type="string", paramType="form", defaultValue="瓶" ),
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdocument_status", description="数据状态", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fname", description="物料名称", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fnumber", description="物料编码", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fratio", description="换算成销售单位乘数", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsale_unit", description="销售单位", required=false,type="string", paramType="form", defaultValue="箱" ),
    *          @SWG\Parameter(name="fspecification", description="规格", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'Material.update', 'uses' => 'MaterialController@update']);

    /**
    * @SWG\Api(
    *     path="/api/material/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="material-delete",
    *      summary="删除物料（商品）",
    *      notes="删除物料（商品）",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'Material.delete', 'uses' => 'MaterialController@destroy']);

});