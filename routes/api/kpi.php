<?php
/**
* @SWG\Resource(
*  resourcePath="/kpi",
*  description="Kpi"
* )
*/
Route::group(['prefix' => 'kpi', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/kpi",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="kpi-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:Kpi",
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
    Route::get('/', ['as' => 'Kpi.index', 'uses' => 'KpiController@index']);

    /**
    * @SWG\Api(
    *     path="/api/kpi/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="kpi-show",
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
    Route::get('/{id}', ['as' => 'Kpi.show', 'uses' => 'KpiController@show']);

    /**
    * @SWG\Api(
    *     path="/api/kpi",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="kpi-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fapr", description="四月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="faug", description="八月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fdec", description="十二月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="feb", description="二月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="femp_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fjan", description="一月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fjul", description="七月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fjun", description="六月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fmar", description="三月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fmay", description="五月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fnov", description="十一月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="foct", description="十月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fsep", description="九月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="ftype", description="指标类型（0-目标拜访量,1-目标销售额）", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fyear", description="年份", required=false,type="integer", paramType="form", defaultValue="" ),
                *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'Kpi.store', 'uses' => 'KpiController@store']);

    /**
    * @SWG\Api(
    *     path="/api/kpi/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="kpi-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fapr", description="四月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="faug", description="八月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fdec", description="十二月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="feb", description="二月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="femp_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fjan", description="一月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fjul", description="七月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fjun", description="六月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fmar", description="三月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fmay", description="五月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fnov", description="十一月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="foct", description="十月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="fsep", description="九月份kpi指标", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="ftype", description="指标类型（0-目标拜访量,1-目标销售额）", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fyear", description="年份", required=false,type="integer", paramType="form", defaultValue="" ),
                *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'Kpi.update', 'uses' => 'KpiController@update']);

    /**
    * @SWG\Api(
    *     path="/api/kpi/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="kpi-delete",
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
    Route::delete('/{id}', ['as' => 'Kpi.delete', 'uses' => 'KpiController@destroy']);

});