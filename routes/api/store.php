<?php
/**
 * @SWG\Resource(
 *  resourcePath="/store",
 *  description="门店"
 * )
 */
Route::group(['prefix' => 'store', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/store",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="store-list",
     *      summary="门店列表",
     *      notes="门店列表",
     *      type="array",
     *     items="$ref:Store",
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
    Route::get('/', ['as' => 'store.index', 'uses' => 'StoreController@index']);

	/**
	 * @SWG\Api(
	 *     path="/api/store/no-signed-list",
	 *     @SWG\Operation(
	 *      method="GET",
	 *      nickname="no-signed-list",
	 *      summary="未签约门店列表",
	 *      notes="未签约门店列表",
	 *      type="array",
	 *      items="$ref:Store",
	 *      @SWG\Parameters(
	 *          @SWG\Parameter(name="femp_id", description="femp_id", required=true, type="integer", paramType="query", defaultValue="1"),
	 *          @SWG\Parameter(name="fpolicy_id", description="陈列政策id", required=true, type="integer", paramType="query", defaultValue="1"),
	 *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
	 *      )
	 *  )
	 * )
	 */
	Route::get('/no-signed-list', ['as' => 'store.noSignedList', 'uses' => 'StoreController@noSignedList']);

    /**
     * @SWG\Api(
     *     path="/api/store/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="store-show",
     *      summary="门店详情",
     *      notes="门店详情",
     *      type="Store",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'store.show', 'uses' => 'StoreController@show']);

    /**
     * @SWG\Api(
     *     path="/api/store",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="store-store",
     *      summary="新增门店",
     *      notes="新增门店",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="faccountnum", description="账户", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="faddress", description="详细地址", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="farea", description="面积", required=false,type="string", paramType="form", defaultValue="0.00" ),
                @SWG\Parameter(name="farea_unit", description="单位", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fbankaccount", description="开户银行", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fbusslicense", description="营业执照", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fchannel", description="渠道分类", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fcity", description="城市", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcontracts", description="联系人", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcountry", description="区县", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcust_id", description="客户id", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdutyparagraphe", description="税号", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="femail", description="联系人email", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="femp_id", description="负责业务员", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="ffax", description="联系人传真", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ffullname", description="全名", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="flatitude", description="纬度", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="flevel", description="门店等级", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="flongitude", description="经度", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmode", description="配送模式", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fnumber", description="编号", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fphone", description="联系人手机", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fphoto", description="门店图片", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fpostalcode", description="邮编", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fprovince", description="省份", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fremark", description="描述", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fshortname", description="简称", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fstreet", description="街道", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftelephone", description="联系人电话", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftitle", description="联系人职位", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftran_cust_id", description="配送商id", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fline_id", description="线路id", required=false,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'store.store', 'uses' => 'StoreController@store']);

    /**
     * @SWG\Api(
     *     path="/api/store/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="store-update",
     *      summary="门店更新",
     *      notes="门店更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="faccountnum", description="账户", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="faddress", description="详细地址", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="farea", description="面积", required=false,type="string", paramType="form", defaultValue="0.00" ),
                @SWG\Parameter(name="farea_unit", description="单位", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fbankaccount", description="开户银行", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fbusslicense", description="营业执照", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fchannel", description="渠道分类", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fcity", description="城市", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcontracts", description="联系人", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcountry", description="区县", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcust_id", description="客户id", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fdutyparagraphe", description="税号", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="femail", description="联系人email", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="femp_id", description="负责业务员", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="ffax", description="联系人传真", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ffullname", description="全名", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="flatitude", description="纬度", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="flevel", description="门店等级", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="flongitude", description="经度", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fmode", description="配送模式", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fnumber", description="编号", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="forg_id", description="组织id", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fphone", description="联系人手机", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fphoto", description="门店图片", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fpostalcode", description="邮编", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fprovince", description="省份", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fremark", description="描述", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fshortname", description="简称", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fstreet", description="街道", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftelephone", description="联系人电话", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftitle", description="联系人职位", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftran_cust_id", description="配送商id", required=false,type="integer", paramType="form", defaultValue="0" ),
     *          @SWG\Parameter(name="fline_id", description="线路id", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'store.update', 'uses' => 'StoreController@update']);

    /**
     * @SWG\Api(
     *     path="/api/store/{id}",
     *     @SWG\Operation(
     *      method="DELETE",
     *      nickname="store-delete",
     *      summary="门店删除",
     *      notes="门店删除",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::delete('/{id}', ['as' => 'store.delete', 'uses' => 'StoreController@destroy']);




});