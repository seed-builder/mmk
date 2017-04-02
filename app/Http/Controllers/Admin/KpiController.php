<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\Kpi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KpiController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Kpi($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
        $ids = $this->getCurUsersEmployeeIds();
        $employees = Employee::query()->whereIn('id',$ids)->get();
		return view('admin.kpi.index',compact('employees'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.kpi.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = Kpi::find($id);
		return view('admin.kpi.edit', ['entity' => $entity]);
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

		$searchCols = ["fdocument_status"];
        $with = ['employee'];
		return parent::pagination($request, $searchCols,$with);
	}

	public function store(Request $request, $extraFields = [])
    {
        $data = $request->except('_token');

        if (empty($data))
            return response()->json([
                'code' => 500,
                'result' => '数据不能为空'
            ]);
        if (!empty($fieldErrors)) {
            return response()->json([
                'code' => 500,
                'result' => $fieldErrors
            ]);
        } else {
            $kpis = [];
            $empids = $data['femp_id'];
            unset($data['femp_id']);

            Kpi::query()->whereIn('femp_id',$empids)->where('fyear',$data['fyear'])->delete();
            foreach ($empids as $d){
                $data['femp_id'] = $d;
                $data['fcreator_id'] = Auth::user()->id;
                $data['fcreate_date'] = date('Y-m-d H:i:s');
                $kpis[] = $data;
            }

            DB::table('bd_kpis')->insert($kpis);
            return response()->json([
                'code' => 200,
                'result' => '业绩设置成功！'
            ]);
        }


    }

    public function formFilter($queryBuilder, $data)
    {
        foreach ($data as $f){

            if (empty($f['value']))
                continue;

            switch ($f['name']){
                case "employee_fphone" : {
                    $ids = Employee::query()->where('fphone','like','%'.$f['value'].'%')->pluck('id');
                    $queryBuilder->whereIn('femp_id', $ids);
                    break;
                }
                case "employee_fname" : {
                    $ids = Employee::query()->where('fname','like','%'.$f['value'].'%')->pluck('id');
                    $queryBuilder->whereIn('femp_id', $ids);
                    break;
                }
                default : {
                    $queryBuilder=$this->adminFilterQuery($queryBuilder,$f);
                }
            }
        }
    }

}
