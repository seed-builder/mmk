<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\Stock;
use Illuminate\Support\Facades\Auth;

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
		return parent::pagination($request, $searchCols, ['store.employee', 'material']);
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
