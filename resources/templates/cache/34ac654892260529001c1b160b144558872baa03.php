<?php
if(!function_exists('dataTypeFilter')){
	function dataTypeFilter($data_type){
		return $data_type == 'datetime' ? 'string' : $data_type;
	}
}
?>
<?php echo $BEGIN_PHP; ?>

/**
* @SWG\Resource(
*  resourcePath="/<?php echo e(snake_case($model,'-')); ?>",
*  description="<?php echo e($model); ?>"
* )
*/
Route::group(['prefix' => '<?php echo e(snake_case($model,'-')); ?>', 'middleware' => 'api.sign'], function () {

    /**
    * @SWG\Api(
    *     path="/api/<?php echo e(snake_case($model,'-')); ?>",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="<?php echo e(snake_case($model,'-')); ?>-list",
    *      summary="page list",
    *      notes="page list",
    *      type="array",
    *     items="$ref:<?php echo e($model); ?>",
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
    Route::get('/', ['as' => '<?php echo e($model); ?>.index', 'uses' => '<?php echo e($model); ?>Controller@index']);

    /**
    * @SWG\Api(
    *     path="/api/<?php echo e(snake_case($model,'-')); ?>/{id}",
    *     @SWG\Operation(
    *      method="GET",
    *      nickname="<?php echo e(snake_case($model,'-')); ?>-show",
    *      summary="信息详情",
    *      notes="信息详情",
    *      type="<?php echo e($model); ?>",
    *      @SWG\Parameters(
    *          @SWG\Parameter(name="id", description="id", required=true, type="integer", paramType="path", defaultValue="1"),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="query", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::get('/{id}', ['as' => '<?php echo e($model); ?>.show', 'uses' => '<?php echo e($model); ?>Controller@show']);

    /**
    * @SWG\Api(
    *     path="/api/<?php echo e(snake_case($model,'-')); ?>",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="<?php echo e(snake_case($model,'-')); ?>-store",
    *      summary="新增",
    *      notes="新增",
    *      type="<?php echo e($model); ?>",
    *      @SWG\Parameters(
<?php $__empty_1 = true; $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php if($col->name != 'id'): ?>
*          @SWG\Parameter(name="<?php echo e($col->name); ?>", description="<?php echo e($col->comment); ?>", required=<?php echo e($col->is_nullable ? 'true':'false'); ?>,type="<?=dataTypeFilter($col->data_type)?>", paramType="form", defaultValue="<?php echo e($col->default_value); ?>" ),
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<?php endif; ?>
*          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/', ['as' => '<?php echo e($model); ?>.store', 'uses' => '<?php echo e($model); ?>Controller@store']);

    /**
    * @SWG\Api(
    *     path="/api/<?php echo e(snake_case($model,'-')); ?>/{id}",
    *     @SWG\Operation(
    *      method="POST",
    *      nickname="<?php echo e(snake_case($model,'-')); ?>-update",
    *      summary="更新",
    *      notes="更新",
    *      type="<?php echo e($model); ?>",
    *      @SWG\Parameters(
<?php $__empty_1 = true; $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php if($col->name != 'id'): ?>
*          @SWG\Parameter(name="<?php echo e($col->name); ?>", description="<?php echo e($col->comment); ?>", required=false,type="<?=dataTypeFilter($col->data_type)?>", paramType="form", defaultValue="<?php echo e($col->default_value); ?>" ),
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<?php endif; ?>
*          @SWG\Parameter(name="id", description="id", required=true,type="integer", paramType="path", defaultValue="" ),
    *          @SWG\Parameter(name="_sign", description="签名", required=true, type="string", paramType="form", defaultValue="****")
    *      )
    *  )
    * )
    */
    Route::post('/{id}', ['as' => '<?php echo e($model); ?>.update', 'uses' => '<?php echo e($model); ?>Controller@update']);

    /**
    * @SWG\Api(
    *     path="/api/<?php echo e(snake_case($model,'-')); ?>/{id}",
    *     @SWG\Operation(
    *      method="DELETE",
    *      nickname="<?php echo e(snake_case($model,'-')); ?>-delete",
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
    Route::delete('/{id}', ['as' => '<?php echo e($model); ?>.delete', 'uses' => '<?php echo e($model); ?>Controller@destroy']);

});