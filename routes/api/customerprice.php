<?php
/**
* @SWG\Resource(
*  resourcePath="/customer-price",
*  description="CustomerPrice"
* )
*/
Route::group(['prefix' => 'customer-price', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/customer-price/get-by-store",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="customer-price-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:CustomerPrice",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="store_id", description="门店id", required=false, type="integer", paramType="query", defaultValue="1"),
    *          @SWG\Parameter(name="material_id", description="物料id", required=false, type="integer", paramType="query", defaultValue="10"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *    )
    * )
    */
    Route::get('/get-by-store', ['as' => 'CustomerPrice.getByStore', 'uses' => 'CustomerPriceController@getByStore']);


});