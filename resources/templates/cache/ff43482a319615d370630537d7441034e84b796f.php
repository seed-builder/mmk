<?php echo $BEGIN_PHP; ?>


namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\<?php echo e($model); ?>;

class <?php echo e($model); ?>Controller extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new <?php echo e($model); ?>($attributes);
	}
}