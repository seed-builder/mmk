<?php
/**
* @SWG\Resource(
*  resourcePath="/store-change",
*  description="StoreChange"
* )
*/
Route::group(['prefix' => 'store-change', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/store-change",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="store-change-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:StoreChange",
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
    Route::get('/', ['as' => 'StoreChange.index', 'uses' => 'StoreChangeController@index']);

    /**
    * @SWG\Api(
    *     path="/api/store-change/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="store-change-show",
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
    Route::get('/{id}', ['as' => 'StoreChange.show', 'uses' => 'StoreChangeController@show']);

    /**
    * @SWG\Api(
    *     path="/api/store-change",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="store-change-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="faccountnum", description="账户", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="faddress", description="详细地址", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="farea", description="面积", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="farea_unit", description="单位", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fauditor_id", description="审核人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="faudit_date", description="审核日期", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fbankaccount", description="开户银行", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fbusslicense", description="营业执照", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fchannel", description="渠道分类", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fcity", description="城市", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcontracts", description="联系人", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcountry", description="区县", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fcust_id", description="客户id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="C" ),
            *          @SWG\Parameter(name="fdutyparagraphe", description="税号", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="femail", description="联系人email", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="femp_id", description="负责业务员", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="ffax", description="联系人传真", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fforbidder_id", description="禁用人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fforbid_date", description="禁用日期", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fforbid_status", description="禁用状态", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="ffullname", description="全名", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fis_signed", description="是否签约", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="flatitude", description="纬度", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="flevel", description="门店等级", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fline_id", description="line id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="flongitude", description="经度", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmode", description="配送模式", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fnumber", description="编号", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fphone", description="联系人手机", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fphoto", description="门店图片", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fpostalcode", description="邮编", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fprovince", description="省份", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fremark", description="描述", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fshortname", description="简称", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fstore_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fstreet", description="街道", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="ftelephone", description="联系人电话", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="ftitle", description="联系人职位", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="ftran_cust_id", description="配送商id", required=false,type="integer", paramType="form", defaultValue="0" ),
                *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'StoreChange.store', 'uses' => 'StoreChangeController@store']);

    /**
    * @SWG\Api(
    *     path="/api/store-change/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="store-change-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="faccountnum", description="账户", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="faddress", description="详细地址", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="farea", description="面积", required=false,type="number", paramType="form", defaultValue="0.00" ),
            *          @SWG\Parameter(name="farea_unit", description="单位", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fauditor_id", description="审核人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="faudit_date", description="审核日期", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fbankaccount", description="开户银行", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fbusslicense", description="营业执照", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fchannel", description="渠道分类", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fcity", description="城市", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcontracts", description="联系人", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcountry", description="区县", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreate_date", description="创建时间", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fcreator_id", description="创建人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fcust_id", description="客户id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fdocument_status", description="审核状态", required=false,type="string", paramType="form", defaultValue="C" ),
            *          @SWG\Parameter(name="fdutyparagraphe", description="税号", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="femail", description="联系人email", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="femp_id", description="负责业务员", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="ffax", description="联系人传真", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fforbidder_id", description="禁用人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fforbid_date", description="禁用日期", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fforbid_status", description="禁用状态", required=false,type="string", paramType="form", defaultValue="A" ),
            *          @SWG\Parameter(name="ffullname", description="全名", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fis_signed", description="是否签约", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="flatitude", description="纬度", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="flevel", description="门店等级", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fline_id", description="line id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="flongitude", description="经度", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmode", description="配送模式", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fmodify_date", description="修改时间", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fmodify_id", description="修改人", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fnumber", description="编号", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fphone", description="联系人手机", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fphoto", description="门店图片", required=false,type="integer", paramType="form", defaultValue="0" ),
            *          @SWG\Parameter(name="fpostalcode", description="邮编", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fprovince", description="省份", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fremark", description="描述", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fshortname", description="简称", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fstore_id", description="", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fstreet", description="街道", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="ftelephone", description="联系人电话", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="ftitle", description="联系人职位", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="ftran_cust_id", description="配送商id", required=false,type="integer", paramType="form", defaultValue="0" ),
                *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => 'StoreChange.update', 'uses' => 'StoreChangeController@update']);

    /**
    * @SWG\Api(
    *     path="/api/store-change/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="store-change-delete",
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
    Route::delete('/{id}', ['as' => 'StoreChange.delete', 'uses' => 'StoreChangeController@destroy']);

});