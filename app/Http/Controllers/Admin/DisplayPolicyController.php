<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\DisplayPolicy;

class DisplayPolicyController extends AdminController
{
    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new DisplayPolicy($attributes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $all = Department::all();
        $depts = $all->map(function ($item) {
            return ['label' => $item->fname, 'value' => $item->id];
        });
        return view('admin.display-policy.index', compact('depts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.display-policy.create');
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = DisplayPolicy::find($id);
        return view('admin.display-policy.edit', ['entity' => $entity]);
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
        $searchCols = ["fbill_no", "fexp_type", "fsketch"];
        $with = ['department'];
        $data = $request->all();


        return parent::pagination($request, $searchCols, $with, function ($queryBuilder) use ($data) {
            if (!empty($data['nodeid'])) {//组织树点击查询
                $dept = Department::find($data['nodeid']);
                $deptids = $dept->getAllChildDept()->pluck('id')->toArray();

                $request['queryBuilder'] = $queryBuilder->whereIn('fcost_dept_id', $deptids);
            }
        });
    }

}
