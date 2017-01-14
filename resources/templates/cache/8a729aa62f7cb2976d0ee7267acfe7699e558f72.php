<?php
if(!function_exists('dataTypeFilter')){
function dataTypeFilter($data_type){
	return $data_type == 'datetime' ? 'string' : $data_type;
}
}
?>
<?php echo $BEGIN_PHP; ?>


namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class <?php echo e($model); ?>

 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="<?php echo e($model); ?>")
 <?php $__empty_1 = true; $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); $__empty_1 = false; ?>
* @SWG\Property(name="<?php echo e($c->name); ?>", type="<?=dataTypeFilter($c->data_type)?>", description="<?php echo e($c->comment); ?>")
 <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); if ($__empty_1): ?>
 <?php endif; ?>
 */
class <?php echo e($model); ?> extends Model
{
	//
	protected $table = '<?php echo e($table); ?>';
	protected $guarded = ['id'];
}
