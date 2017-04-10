<?php
if(!function_exists('dataTypeFilter')){
	function dataTypeFilter($data_type){
		return $data_type == 'datetime' ? 'string' : $data_type;
	}
}
?>
{!! $BEGIN_PHP !!}
/**
* @SWG\Resource(
*  resourcePath="/{{snake_case($model,'-')}}",
*  description="{{$model}}"
* )
*/
Route::group(['prefix' => '{{snake_case($model,'-')}}', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/{{snake_case($model,'-')}}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="{{snake_case($model,'-')}}-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:{{$model}}",
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
    Route::get('/', ['as' => '{{$model}}.index', 'uses' => '{{$model}}Controller@index']);

    /**
    * @SWG\Api(
    *     path="/api/{{snake_case($model,'-')}}/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="{{snake_case($model,'-')}}-show",
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
    Route::get('/{id}', ['as' => '{{$model}}.show', 'uses' => '{{$model}}Controller@show']);

    /**
    * @SWG\Api(
    *     path="/api/{{snake_case($model,'-')}}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="{{snake_case($model,'-')}}-store",
    *      summary="新增",
    *      notes="新增",
    *      type="",
    *      @SWG\Parameters(
@forelse($columns as $col)
    @if($col->name != 'id')
*          @SWG\Parameter(name="{{$col->name}}", description="{{$col->comment}}", required={{$col->is_nullable ? 'true':'false'}},type="<?=dataTypeFilter($col->data_type)?>", paramType="form", defaultValue="{{$col->default_value}}" ),
    @endif
    @empty
@endforelse
*          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => '{{$model}}.store', 'uses' => '{{$model}}Controller@store']);

    /**
    * @SWG\Api(
    *     path="/api/{{snake_case($model,'-')}}/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="{{snake_case($model,'-')}}-update",
    *      summary="更新",
    *      notes="更新",
    *      type="",
    *      @SWG\Parameters(
@forelse($columns as $col)
    @if($col->name != 'id')
*          @SWG\Parameter(name="{{$col->name}}", description="{{$col->comment}}", required=false,type="<?=dataTypeFilter($col->data_type)?>", paramType="form", defaultValue="{{$col->default_value}}" ),
    @endif
    @empty
@endforelse
*          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => '{{$model}}.update', 'uses' => '{{$model}}Controller@update']);

    /**
    * @SWG\Api(
    *     path="/api/{{snake_case($model,'-')}}/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="{{snake_case($model,'-')}}-delete",
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
    Route::delete('/{id}', ['as' => '{{$model}}.delete', 'uses' => '{{$model}}Controller@destroy']);

});