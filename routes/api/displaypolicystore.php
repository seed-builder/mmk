<?php
/**
* @SWG\Resource(
*  resourcePath="/display-policy-store",
*  description="陈列费用签约门店"
* )
*/
Route::group(['prefix' => 'display-policy-store', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/display-policy-store",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="display-policy-store-list",
    *      summary="陈列费用签约门店列表",
    *      notes="陈列费用签约门店列表",
    *      type="array",
    *     items="$ref:DisplayPolicyStore",
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
    Route::get('/', ['as' => 'DisplayPolicyStore.index', 'uses' => 'DisplayPolicyStoreController@index']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy-store/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="display-policy-store-show",
    *      summary="陈列费用签约门店信息详情",
    *      notes="陈列费用签约门店信息详情",
    *      type="Attendance",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'DisplayPolicyStore.show', 'uses' => 'DisplayPolicyStoreController@show']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy-store",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="display-policy-store-store",
    *      summary="新增陈列费用签约门店",
    *      notes="新增陈列费用签约门店",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="famount", description="费用总金额", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fbill_no", description="bill no", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcheck_amount", description="核定签约金额", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fcheck_status", description="验证状态", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fcost_dept_id", description="应用区域(部门 id)", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdate", description="签约日期", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="femp_id", description="业务员id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fend_date", description="门店方案执行结束日期 ", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fpolicy_id", description="方案id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsign_amount", description="签约金额", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fsketch", description="项目简述", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstart_date", description="门店方案执行开始日期", required=true,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstatus", description="签约状态", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fstore_id", description="门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'DisplayPolicyStore.store', 'uses' => 'DisplayPolicyStoreController@store']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy-store/{id}",
    *     @SWG\Operation(
    *      method="PUT",
    *      nickname="display-policy-store-update",
    *      summary="更新陈列费用签约门店",
    *      notes="更新陈列费用签约门店",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="famount", description="费用总金额", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fbill_no", description="bill no", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcheck_amount", description="核定签约金额", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fcheck_status", description="验证状态", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fcost_dept_id", description="应用区域(部门 id)", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fdate", description="签约日期", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fdocument_status", description="数据状态(A 是创建 B是审核中 C是已审核 D是重新审核)", required=false,type="string", paramType="form", defaultValue="A" ),
    *          @SWG\Parameter(name="femp_id", description="业务员id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fend_date", description="门店方案执行结束日期 ", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fpolicy_id", description="方案id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fsign_amount", description="签约金额", required=false,type="number", paramType="form", defaultValue="0.00" ),
    *          @SWG\Parameter(name="fsketch", description="项目简述", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstart_date", description="门店方案执行开始日期", required=false,type="string", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="fstatus", description="签约状态", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="fstore_id", description="门店id", required=false,type="integer", paramType="form", defaultValue="0" ),
    *          @SWG\Parameter(name="id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::put('/{id}', ['as' => 'DisplayPolicyStore.update', 'uses' => 'DisplayPolicyStoreController@update']);

    /**
    * @SWG\Api(
    *     path="/api/display-policy-store/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="display-policy-store-delete",
    *      summary="删除陈列费用签约门店",
    *      notes="删除陈列费用签约门店",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'DisplayPolicyStore.delete', 'uses' => 'DisplayPolicyStoreController@destroy']);

});