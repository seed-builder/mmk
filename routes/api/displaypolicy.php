<?php
/**
* @SWG\Resource(
*  resourcePath="/display-policy",
*  description="陈列费用政策"
* )
*/
Route::group(['prefix' => 'display-policy', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/display-policy",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="display-policy-list",
    *      summary="陈列费用政策列表",
    *      notes="陈列费用政策列表",
    *      type="array",
    *     items="$ref:DisplayPolicy",
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
    Route::get('/', ['as' => 'DisplayPolicy.index', 'uses' => 'DisplayPolicyController@index']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="display-policy-show",
    *      summary="陈列费用政策信息详情",
    *      notes="陈列费用政策信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'DisplayPolicy.show', 'uses' => 'DisplayPolicyController@show']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="display-policy-store",
    *      summary="新增陈列费用政策",
    *      notes="新增陈列费用政策",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fact_store_num", description="执行门店总数", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="famount", description="总金额", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fcost_dept_id", description="应用区域(部门 id)", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fend_date", description="执行结束日期 ", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fexp_type", description="费用类别", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsign_amount", description="已签约总金额", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsign_store_num", description="已签约门店总数", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsketch", description="项目简述", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstart_date", description="执行开始日期", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstore_cost_limit", description="单个门店费用上限", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'DisplayPolicy.store', 'uses' => 'DisplayPolicyController@store']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="display-policy-update",
    *      summary="更新陈列费用政策",
    *      notes="更新陈列费用政策",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="fact_store_num", description="执行门店总数", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="famount", description="总金额", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fbill_no", description="bill no", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcost_dept_id", description="应用区域(部门 id)", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fend_date", description="执行结束日期 ", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fexp_type", description="费用类别", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsign_amount", description="已签约总金额", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsign_store_num", description="已签约门店总数", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsketch", description="项目简述", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstart_date", description="执行开始日期", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstore_cost_limit", description="单个门店费用上限", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'DisplayPolicy.update', 'uses' => 'DisplayPolicyController@update']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="display-policy-delete",
    *      summary="删除陈列费用政策",
    *      notes="删除陈列费用政策",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'DisplayPolicy.delete', 'uses' => 'DisplayPolicyController@destroy']);

});