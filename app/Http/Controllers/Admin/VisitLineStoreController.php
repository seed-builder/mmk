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
     * @return \Illuminate\Http\JsonResponse
     */
    public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null)
    {
        $searchCols = ["fline_id", "femp_id"];
        $data = $request->all();

        return parent::pagination($request, $searchCols, $with, function ($queryBuilder) use ($data) {
            if (!empty($data['nodeid'])) {//组织树点击查询
                $emp = Employee::find($data['nodeid']);

                if (empty($emp)) {
                    $dept = Department::find($data['nodeid']);
                    $emp_ids = $dept->getAllEmployeeByDept()->pluck('id')->toArray();

                    $queryBuilder->whereIn('femp_id', $emp_ids);
                } else {
                    $queryBuilder->where('femp_id', $data['nodeid']);
                }
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
        if (!empty($data['ids'])) {
            $query->whereIn('id', $data['ids']);
        }
        if (!empty($data['fline_id'])) {
            $update['fline_id'] = $data['fline_id'];
        }
        if (!empty($data['femp_id'])) {
            $update['femp_id'] = $data['femp_id'];
            Store::query()->whereIn('id',$data['ids'])->update([
                'femp_id' => $data['femp_id']
            ]);
        }

        return $query->update($update);

    }

    //生成员工线路
    public function makeEmpAllLine(Request $request)
    {
        $data = $request->all();

        if (empty($data['id'])) {//生成所有员工路线

            //$emps = Employee::all();
            $ids = $this->getCurUsersEmployeeIds();

            $datas = [];
            foreach ($ids as $id) {
                $this->makeEmpLine($id);
            }

            return response()->json([
                'code' => 200,
                'result' => '员工路线已全部生成！'
            ]);
        } else if (!empty($data['id'])) { //生成指定员工路线
            $store_count = Store::query()->where('femp_id', $data['id'])->count();

            if ($store_count == 0) { //若该员工无负责门店 则生成失败
                return response()->json([
                    'code' => 500,
                    'result' => '该员工无负责门店，生成线路失败！'
                ]);
            }

            $this->makeEmpLine($data['id']);

            return response()->json([
                'code' => 200,
                'result' => '生成线路成功！'
            ]);
        }

    }

    /*
     * 生成员工路线
     */
    protected function makeEmpLine($emp_id)
    {

        $vls = VisitLineStore::query()->select(['fline_id'])->where('femp_id', $emp_id)->groupBy('fline_id')->distinct()->get();

        $vls_ids = $vls->pluck('fline_id')->toArray();

        $lines = VisitLine::query()->whereNotIn('id', $vls_ids)->get();

        $random_store = Store::query()->where('femp_id', $emp_id)->orderBy(\DB::raw('RAND()'))->take(1)->first();//随机取出用户所负责的一个门店


        if (!empty($random_store)) { //若该员工无负责门店 则生成失败

            foreach ($lines as $l) {

                $vls = VisitLineStore::create([
                    'fline_id' => $l->id,
                    'fstore_id' => $random_store->id,
                    'femp_id' => $emp_id,
                    'fweek_day' => $l->fnumber,
                ]);

            }

        }

    }


}
