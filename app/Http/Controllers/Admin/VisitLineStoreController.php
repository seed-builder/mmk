<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Department;
use App\Models\Busi\Employee;
use App\Models\Busi\Store;
use App\Models\Busi\VisitLineCalendar;
use App\Models\Busi\VisitStoreTodo;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\VisitLineStore;
use App\Models\Busi\VisitLine;
use Illuminate\Support\Facades\DB;

class VisitLineStoreController extends AdminController
{
    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new VisitLineStore($attributes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lines = VisitLine::all();
        $citys = City::query()->where('LevelType', 1)->get();
        $depts = Department::all();
        $todos = VisitStoreTodo::all();
        return view('admin.visit-line-store.index', compact('lines', 'citys', 'depts', 'todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.visit-line-store.create');
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = VisitLineStore::find($id);
        return view('admin.visit-line-store.edit', ['entity' => $entity]);
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

	/**
	 * @param  Request $request
	 * @param  array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
    {
        $searchCols = ["fline_id", "femp_id"];
        $with = ['line','store.channel','employee.department'];

        return parent::pagination($request, $searchCols, $with, function ($queryBuilder) use ($request) {
            $data = $request->all();
            if (!empty($data['distinct'])){
                $queryBuilder->groupBy(explode(',',$data['distinct']))->distinct();
            }

            $ids = $this->getCurUsersEmployeeIds();
            //var_dump($ids);
            if (!empty($ids)) {
                $queryBuilder->whereIn('femp_id', $ids);
            }
        });
    }

    public function destroyAll(Request $request)
    {
        $data = $request->all();
        return VisitLineStore::query()->whereIn('id', $data['ids'])->delete();
    }

    //门店线路互调
    public function storeLineIml(Request $request)
    {
        $data = $request->all();
        $update = $request->except('_token','ids');
        DB::beginTransaction();
        try {
            foreach (explode(",",$data['ids']) as $id){
                $vls = VisitLineStore::find($id);
                $vls->fill($update);
                $vls->save();
            }
            DB::commit();
            return response()->json([
                'code' => 200,
                'result' => '线路调整成功！'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'result' => $e->getMessage()
            ]);
        }

    }

    /*
     * 初始化过滤器
     */
    public  function initFilter($queryBuilder, $data)
    {

        if (!empty($data['distinct']))
            $queryBuilder->groupBy($data['distinct'])->distinct();

        if (!empty($data['femp_id']))
            $queryBuilder->where('femp_id', $data['femp_id']);

        if (!empty($data['fline_id']))
            $queryBuilder->where('fline_id', $data['fline_id']);


        return $queryBuilder;
    }

    /*
     * 查询表单过滤器
     */
    public function formFilter($queryBuilder, $data)
    {
        foreach ($data as $f){

            if (empty($f['value']))
                continue;

            switch ($f['name']){
                case "employee_fname" : {
                    $ids = Employee::query()->where('fname','like','%'.$f['value'].'%')->pluck('id');
                    $queryBuilder->whereIn('femp_id', $ids);
                    break;
                }
                case "store_ffullname" : {
                    $ids = Store::query()->where('ffullname','like','%'.$f['value'].'%')->pluck('id');
                    $queryBuilder->whereIn('fstore_id', $ids);
                    break;
                }
                case "store_fcontracts" : {
                    $ids = Store::query()->where('fcontracts','like','%'.$f['value'].'%')->pluck('id');
                    $queryBuilder->whereIn('fstore_id', $ids);
                    break;
                }
                default : {
                    $queryBuilder=$this->adminFilterQuery($queryBuilder,$f);
                }
            }
        }
    }


}
