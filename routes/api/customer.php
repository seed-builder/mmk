<?php
/**
 * @SWG\Resource(
 *  resourcePath="/customer",
 *  description="客户"
 * )
 */
Route::group(['prefix' => 'customer', 'middleware' => 'api.sign'], function () {

    /**
     * @SWG\Api(
     *     path="/api/customer",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="customer-list",
     *      summary="客户列表",
     *      notes="客户列表",
     *      type="array",
     *     items="$ref:Customer",
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
    Route::get('/', ['as' => 'customer.index', 'uses' => 'CustomerController@index']);

    /**
     * @SWG\Api(
     *     path="/api/customer/{id}",
     *     @SWG\Operation(
     *      method="GET",
     *      nickname="customer-show",
     *      summary="客户详情",
     *      notes="客户详情",
     *      type="Customer",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::get('/{id}', ['as' => 'customer.show', 'uses' => 'CustomerController@show']);

    /**
     * @SWG\Api(
     *     path="/api/customer",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="customer-store",
     *      summary="新增客户",
     *      notes="新增客户",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="faddress", description="通讯地址", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="farea", description="地区", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fbusiness_mode", description="经营模式", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcity", description="城市", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcompany_nature", description="公司性质", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcompany_scale", description="公司规模", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcountry", description="国家", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcust_type_id", description="客户类别", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fdiscount_list_id", description="折扣表", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ffax", description="传真", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fgroup", description="客户分组", required=false,type="string", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="finvoice_type", description="发票类型", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fis_credit_check", description="启用信用管理", required=false,type="integer", paramType="form", defaultValue="0" ),
                @SWG\Parameter(name="fmode_transport", description="运输方式", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fname", description="客户名称", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fprice_list_id", description="价目表", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fprovince", description="省份", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fsale_depart", description="所属营业部", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fseller", description="销售员", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fservice_depart", description="所属服务处", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fshort_name", description="客户简称", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftax_rate", description="默认税率", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftax_register_code", description="纳税登记号", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftax_type", description="税分类", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftel", description="联系电话", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="ftrading_curr_id", description="结算币别", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fwebsite", description="公司网址", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fzip", description="邮政编码", required=false,type="string", paramType="form", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/', ['as' => 'customer.store', 'uses' => 'CustomerController@store']);

    /**
     * @SWG\Api(
     *     path="/api/customer/{id}",
     *     @SWG\Operation(
     *      method="POST",
     *      nickname="customer-update",
     *      summary="客户更新",
     *      notes="客户更新",
     *      type="",
     *      @SWG\Parameters(
     *          @SWG\Parameter(name="flongitude", description="百度地图经度", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="flatitude", description="百度地图纬度", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fstock_address", description="库存地址", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="fcheck_limit", description="限制盘点位置距离（0-不限制，单位：米", required=false,type="string", paramType="form", defaultValue="" ),
                @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
     *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
     *      )
     *  )
     * )
     */
    Route::post('/{id}', ['as' => 'customer.update', 'uses' => 'CustomerController@update']);


});