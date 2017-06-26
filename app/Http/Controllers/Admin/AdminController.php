<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\DatatablesController;
use App\Models\Busi\Department;
use App\Models\Busi\Employee;
use SysConfigRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use App\Services\LogSvr;

abstract class AdminController extends DatatablesController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
    }

    /*
     * 审核
     */
    public function check(Request $request)
    {
        $data = $request->all();
        $ids = explode(",", $data['ids']);
        $entitys = $this->newEntity()->newQuery()->whereIn('id', $ids)->get();

        foreach ($entitys as $entity) {
            $entity->fdocument_status = "C";

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
    public function unCheck(Request $request)
    {
        $data = $request->all();
        $ids = explode(",", $data['ids']);
        $entitys = $this->newEntity()->newQuery()->whereIn('id', $ids)->get();

        foreach ($entitys as $entity) {
            $entity->fdocument_status = "A";

            $entity->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '反审核成功！',
            'data' => $entitys
        ]);
    }

    /**
     * 获取当前登陆用户所能操作的员工id 集合
     * @return mixed
     */
    public function getCurUsersEmployeeIds()
    {
        $empQuery = DB::table('bd_employees');//,[[$emp,'fname','femp_id']]
        $curUser = Auth::user();
        if (!$curUser->isAdmin()) {
            if (SysConfigRepo::isMgtDataIsolate()) {
                $flags = $curUser->positions->pluck('flag')->all();
                if (!empty($flags)) {
                    $empQuery->join('bd_positions', 'bd_employees.fpost_id', '=', 'bd_positions.id');
//				    foreach ($flags as $flag){
//					    $empQuery->orWhere('bd_positions.flag', 'like', $flag. '%');
//				    }
                    $empQuery->where(function ($empQuery) use ($flags) {
                        foreach ($flags as $flag) {
                            $empQuery->orWhere('bd_positions.flag', 'like', $flag . '%');
                        }
                    });
                }
            }
        }
        $entities = $empQuery->select('bd_employees.id')->get();
        $ids = $entities->pluck('id')->all();
        return $ids;
    }

    public function adminFilter($queryBuilder, $request)
    {
        $data = $request->all();

        if (!empty($data['init_filter']))
            $this->initFilter($queryBuilder, $data['init_filter']);

        if (!empty($data['tree']))
            $this->treeFilter($queryBuilder, $data['tree']);

        if (!empty($data['filter']))
            $this->formFilter($queryBuilder, $data['filter']);


        return $queryBuilder;

    }

    public function initFilter($queryBuilder, $data)
    {
        return $queryBuilder;
    }

    public function treeFilter($queryBuilder, $data, $tableAlias = false)
    {
        if ($tableAlias) {
            $col = 'bd_employees.id';
        } else {
            $col = 'femp_id';
        }
        $emp = Employee::find($data['nodeid']);
        if (empty($emp)) {
            $dept = Department::find($data['nodeid']);
            $emp_ids = $dept->getAllEmployeeByDept()->pluck('id')->toArray();

            $queryBuilder->whereIn($col, $emp_ids);
        } else {
            $queryBuilder->where($col, $data['nodeid']);
        }

        return $queryBuilder;
    }

    public function formFilter($queryBuilder, $data)
    {
        foreach ($data as $f) {

            if (empty($f['value']))
                continue;

            $queryBuilder = $this->adminFilterQuery($queryBuilder, $f);

        }

        return $queryBuilder;
    }

    public function adminFilterQuery($queryBuilder, $data)
    {
        $operator = !empty($data['operator']) ? $data['operator'] : '=';

        if ($operator == 'like')
            $queryBuilder->where($data['name'], $operator, '%' . $data['value'] . '%');
        else
            $queryBuilder->where($data['name'], $operator, $data['value']);

        return $queryBuilder;
    }

    public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
    {
        return parent::pagination($request, $searchCols, $with, function (&$query) use ($request, $conditionCall) {
            $filter = $request->input('filter', []);
            $tree = $request->input('tree', []);
            $initFilter = $request->input('init_filter', []);
            if (!empty($filter) || !empty($tree) || !empty($initFilter)) {
                $this->adminFilter($query, $request);
            }
            if ($conditionCall != null && is_callable($conditionCall)) {
                $conditionCall($query);
            }

        }, $all_columns); // TODO: Change the autogenerated stub
    }

    /*
	 * 导出excel
	 */
    public function exportExcel(Request $request, $with = [], $conditionCall = null)
    {
        $queryBuilder = $this->entityQuery(); //$this->newEntity()->newQuery();

        $filter = $request->input('filter', []);
        $tree = $request->input('tree', []);
        $initFilter = $request->input('init_filter', []);
        if (!empty($filter) || !empty($tree) || !empty($initFilter)) {
            $this->adminFilter($queryBuilder, $request);
        }

        if (!empty($with)) {
            $queryBuilder->with($with);
        }


        if ($conditionCall != null && is_callable($conditionCall)) {
            $conditionCall($queryBuilder);
        }

        $entities = $queryBuilder->get();

        $this->export($entities);
    }

	public function export($datas){
    	throw new \Exception("need implement");
	}

}
