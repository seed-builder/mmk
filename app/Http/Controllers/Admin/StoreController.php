<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\Department;
use App\Models\Busi\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Store;

class StoreController extends AdminController
{

    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Store($attributes);
	}

	public function index()
	{
		return view('admin.store.index');
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = []){
		$searchCols = ['fnumber', 'ffullname', 'fshortname','faddress','fcontracts'];

        $data = $request->all();
        $query = Store::query();
        foreach ($data['columns'] as $d) {
            if ($d['data']=='femp_id'&&!empty($d['search']['value'])){
                $emp_count = Employee::query()->where('id',$d['search']['value'])->count();
                if ($emp_count==0){
                    $emps = Employee::query()->where('fdept_id',$d['search']['value'])->get();
                    $ids = [];
                    foreach ($emps as $e){
                        $ids[] = $e->id;
                    }
                    $query->whereIn('femp_id',$ids);
                }else{
                    $query->where('femp_id',$d['search']['value']);
                }


                $request['queryBuilder'] = $query;
            }
        }
		return parent::pagination($request, $searchCols);
	}

}
