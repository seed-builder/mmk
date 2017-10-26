<?php echo $BEGIN_PHP; ?>

<?php
		$searchCols = [];
		foreach ($columns as $col){
			if($col->data_type == 'string'){
				$searchCols[] = $col->name;
			}
		}

?>
namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Customer\BaseController;
use App\Models\Busi\<?php echo e($model); ?>;

class <?php echo e($model); ?>Controller extends BaseController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new <?php echo e($model); ?>($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('customer.<?php echo e(snake_case($model,'-')); ?>.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('customer.<?php echo e(snake_case($model,'-')); ?>.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = <?php echo e($model); ?>::find($id);
		return view('customer.<?php echo e(snake_case($model,'-')); ?>.edit', ['entity' => $entity]);
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function show($id)
	{
		//
	}

	/**
	* @param  Request $request
	* @param  array $searchCols
	* @param  array $with
	* @param  null $conditionCall
	* @param  bool $all_columns
	* @return  \Illuminate\Http\JsonResponse
	*/
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$searchCols = <?php echo json_encode($searchCols); ?>;
		return parent::pagination($request, $searchCols);
	}

}
