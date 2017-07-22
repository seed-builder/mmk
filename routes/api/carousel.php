<?php
/**
* @SWG\Resource(
*  resourcePath="/carousel",
*  description="Carousel"
* )
*/
Route::group(['prefix' => 'carousel', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/carousel",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="carousel-list",
    *      summary="APP轮播图列表",
    *      notes="APP轮播图列表",
    *      type="array",
    *     items="$ref:Carousel",
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
    Route::get('/', ['as' => 'Carousel.index', 'uses' => 'CarouselController@index']);

    /**
    * @SWG\Api(
    *     path="/api/carousel/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="carousel-show",
    *      summary="信息详情",
    *      notes="信息详情",
    *      type="Carousel",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => 'Carousel.show', 'uses' => 'CarouselController@show']);

    /**
    * @SWG\Api(
    *     path="/api/carousel",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="carousel-store",
    *      summary="新增",
    *      notes="新增",
    *      type="Carousel",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="created_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fname", description="图片名称", required=true,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fpicture_id", description="图片id", required=true,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fseq", description="排序", required=false,type="integer", paramType="form", defaultValue="0" ),
                    *          @SWG\Parameter(name="updated_at", description="", required=true,type="string", paramType="form", defaultValue="" ),
        *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => 'Carousel.store', 'uses' => 'CarouselController@store']);

    /**
    * @SWG\Api(
    *     path="/api/carousel/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="carousel-update",
    *      summary="更新",
    *      notes="更新",
    *      type="Carousel",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="created_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fname", description="图片名称", required=false,type="string", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fpicture_id", description="图片id", required=false,type="integer", paramType="form", defaultValue="" ),
            *          @SWG\Parameter(name="fseq", description="排序", required=false,type="integer", paramType="form", defaultValue="0" ),
                    *          @SWG\Parameter(name="updated_at", description="", required=false,type="string", paramType="form", defaultValue="" ),
        *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => 'Carousel.update', 'uses' => 'CarouselController@update']);

    /**
    * @SWG\Api(
    *     path="/api/carousel/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="carousel-delete",
    *      summary="删除",
    *      notes="删除",
    *      type="",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="1" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::delete('/{id}', ['as' => 'Carousel.delete', 'uses' => 'CarouselController@destroy']);

});