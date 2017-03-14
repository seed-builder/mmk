<?php echo $BEGIN_PHP; ?>

Route::get('<?php echo e(snake_case($model,'-')); ?>/pagination', ['uses' => '<?php echo e($model); ?>Controller@pagination']);
Route::resource('<?php echo e(snake_case($model,'-')); ?>', '<?php echo e($model); ?>Controller');