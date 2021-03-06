<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Stock($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.stock.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.stock.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = Stock::find($id);
		return view('admin.stock.edit', ['entity' => $entity]);
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

	public function entityQuery()
	{
		return DB::table('st_stocks')
			->select(['st_stocks.*',
				'bd_customers.fname as customer_name',
				'bd_employees.fname as employee_name',
				'bd_employees.fnumber as employee_number',
				'bd_materials.fname as material_name',
				'bd_materials.fnumber as material_number',
				'bd_materials.fspecification as material_specification',
				'st_stores.fnumber as store_number',
				'st_stores.ffullname as store_name',
			])
			->leftJoin('bd_materials', 'bd_materials.id', '=', 'st_stocks.fmaterial_id')
			->leftJoin('bd_employees', 'bd_employees.id', '=', 'st_stocks.femp_id')
			->leftJoin('st_stores', 'st_stores.id', '=', 'st_stocks.fstore_id')
			->leftJoin('bd_customers', 'bd_customers.id', '=', 'st_stores.fcust_id');
		//return parent::entityQuery(); // TODO: Change the autogenerated stub
	}

	/**
	 * @param  Request $request
	 * @param  array $searchCols
	 * @param  array $with
	 * @param  null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$searchCols = ["fdocument_status"];
		return parent::pagination($request, $searchCols, $with, $conditionCall, true);
	}

    /*
     * 审核
     */
    public function check(Request $request){
        $data = $request->all();
        $ids = explode(",",$data['ids']);
        $entitys = $this->newEntity()->newQuery()->whereIn('id',$ids)->get();

        foreach ($entitys as $entity){
            $entity->fdocument_status="C";
            $entity->fcheck_type="B";
            $entity->fcheck_date=date('Y-m-d H:i:s');
            $entity->fchecker=Auth::user()->fname;

            $entity->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '审核成功！',
            'data' => $entitys
        ]);
    }

    /*
     * 反审核
     */
    public function unCheck(Request $request){
        $data = $request->all();
        $ids = explode(",",$data['ids']);
        $entitys = $this->newEntity()->newQuery()->whereIn('id',$ids)->get();

        foreach ($entitys as $entity){
            $entity->fdocument_status="A";
            $entity->fcheck_type="B";
            $entity->fcheck_date=date('Y-m-d H:i:s');
            $entity->fchecker=Auth::user()->fname;

            $entity->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '反审核成功！',
            'data' => $entitys
        ]);
    }
}
