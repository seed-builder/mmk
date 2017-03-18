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
        $data = $request->all();
        $with = ['line','store','employee.department'];

        return parent::pagination($request, $searchCols, $with, function ($queryBuilder) use ($data,$request) {
            $tree = $request->input('tree',[]);
            if (!empty($tree['nodeid'])) {//组织树点击查询
                $emp = Employee::find($tree['nodeid']);
                if (empty($emp)) {
                    $dept = Department::find($tree['nodeid']);
                    $emp_ids = $dept->getAllEmployeeByDept()->pluck('id')->toArray();

                    $queryBuilder->whereIn('femp_id', $emp_ids);
                } else {
                    $queryBuilder->where('femp_id', $tree['nodeid']);
                }
            }

            if (!empty($data['femp'])){
                $ids = Employee::query()->where('fname','like','%'.$data['femp'].'%')->pluck('id');
                $queryBuilder->whereIn('femp_id', $ids);
            }
            if (!empty($data['fstore'])){
                $ids = Store::query()->where('ffullname','like','%'.$data['fstore'].'%')->pluck('id');
                $queryBuilder->whereIn('fstore_id', $ids);
            }
            if (!empty($data['fcontracts'])){
                $ids = Store::query()->where('fcontracts','like','%'.$data['fcontracts'].'%')->pluck('id');
                $queryBuilder->whereIn('fstore_id', $ids);
            }
            if (!empty($data['femp_id'])){
                $queryBuilder->where('femp_id', $data['femp_id']);
            }
            if (!empty($data['fline_id'])){
                $queryBuilder->where('fline_id', $data['fline_id']);
            }

            if (!empty($data['distinctfields'])) {
                $queryBuilder->groupBy($data['distinctfields'])->distinct();
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
        $query = VisitLineStore::query();

        $update = [];
        $store_ids = explode(",",$data['ids']);

        $query->whereIn('id', $store_ids);

        if (!empty($data['fline_id'])) {
            $update['fline_id'] = $data['fline_id'];
            Store::query()->whereIn('id',$store_ids)->update([
                'fline_id' => $data['fline_id']
            ]);
        }
        if (!empty($data['femp_id'])) {
            $update['femp_id'] = $data['femp_id'];
            Store::query()->whereIn('id',$store_ids)->update([
                'femp_id' => $data['femp_id']
            ]);
        }
        if ($query->update($update))
            return response()->json([
                'code' => 200,
                'result' => '线路调整成功！'
            ]);

    }


}
