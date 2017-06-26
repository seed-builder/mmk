<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\Position;
use App\Repositories\ISysConfigRepo;
use App\Services\DataSync\DefaultFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Employee;
use App\Models\Busi\Organization;
use Swagger\Annotations\Items;
use App\Models\Busi\Department;
use Auth;
use SysConfigRepo;
use DB;

class EmployeeController extends AdminController
{

    //
    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new Employee($attributes);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $all = Organization::all();
        $orgs = $all->map(function ($item) {
            return ['label' => $item->fname, 'value' => $item->id];
        });
        //department options
        $topDepts = Department::where('fpardept_id', 0)->get();
        $deptOptions = [];
        foreach ($topDepts as $dept) {
            $this->toSelectOption($dept, ['label' => 'fname', 'value' => 'id'], $deptOptions);
        }
        //position options
        $topPositions = Position::where('fparpost_id', 0)->get();
        $positOptions = [];
        foreach ($topPositions as $position) {
            $this->toSelectOption($position, ['label' => 'fname', 'value' => 'id'], $positOptions);
        }
        return view('admin.employee.index', compact('orgs', 'deptOptions', 'positOptions'));
    }

//	/**
//	 * @param Request $request
//	 * @param array $searchCols
//	 * @param array $with
//	 * @param null $conditionCall
//	 * @return \Illuminate\Http\JsonResponse
//	 */
//	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null){
//		$searchCols = ['fname', 'fnumber', 'fphone'];
//		$data = $request->all();
//		return parent::pagination($request, $searchCols, $with, function($queryBuilder)use($data){
//			//$queryBuilder = DB::table('bd_employees');
//			if(!empty($data['nodeid'])){//组织树点击查询
//				$dept = Department::find($data['nodeid']);
//				$deptids = $dept->getAllChildDept()->pluck('id')->toArray();
//				$queryBuilder->whereIn('fdept_id',$deptids);
//			}
//			$curUser = Auth::user();
//			if(!$curUser->isAdmin()) {
//				//$repo = app('App\Repositories\ISysConfigRepo');
//				if (SysConfigRepo::isMgtDataIsolate()) {
//					$fnumbers = $curUser->positions->pluck('fnumber')->all();
//					if(!empty($fnumbers)) {
//						$queryBuilder->join('bd_positions', 'bd_employees.fpost_id', '=', 'bd_positions.id');
//						foreach ($fnumbers as $fnumber){
//							$queryBuilder->where('bd_positions.fnumber', 'like', $fnumber. '%');
//						}
//					}
//				}
//			}
//		});
//	}

    public function employeeTree()
    {
        $top = Department::where('fpardept_id', 0)->first();
        $emp_ids = $this->getCurUsersEmployeeIds();
        $tree = $this->toBootstrapTreeViewData2($top, ['text' => 'fname', 'dataid' => 'id'], false, $emp_ids);
        $tree['state'] = ['expanded' => true];
        return response()->json([$tree]);
    }

    /**
     * 将实体数据转换成树形（bootstrap treeview）数据
     * @param $entity
     * @param $props 属性映射集合 ['text' => 'name', 'data-id' => 'id']
     * @param bool $expanded
     * @return array
     */
    public function toBootstrapTreeViewData2($entity, $props, $expanded = true, $emp_ids)
    {
        $data = ['item' => $entity];
        if (!empty($entity)) {
            foreach ($props as $k => $val) {
                $data[$k] = $entity->{$val};
                $data['icon'] = 'fa fa-users';
                $data['state'] = ['expanded' => $expanded];
                $data['nodetype'] = 'dept';
            }
            $nodes = [];
            if (!empty($entity->children)) {
                foreach ($entity->children as $child) {
                    $nodes[] = $this->toBootstrapTreeViewData2($child, $props, $expanded, $emp_ids);
                }
            }
            //find employee
            $employees = Employee::query()->where('fdept_id', $entity->id)->whereIn('id', $emp_ids)->get();
            if (!empty($employees)) {
                foreach ($employees as $employee) {
                    $nodes[] = [
                        'text' => $employee->fname,
                        'dataid' => $employee->id,
                        'icon' => 'fa fa-user',
                        'nodetype' => 'emp',
                    ];
                }
            }
            if (!empty($nodes))
                $data['nodes'] = $nodes;
        }
        return $data;
    }

	/**
	 * Datatables UI page
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
    {
        $searchCols = ['bd_employees.fname', 'bd_employees.fnumber', 'bd_employees.fphone'];
        $data = $request->all();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $columns = $request->input('columns', []);
        $order = $request->input('order', []);
        $search = $request->input('search', []);
        $draw = $request->input('draw', 0);
        $filter = $request->input('filter', []);
        $tree = $request->input('tree',[]);

        $queryBuilder = DB::table('bd_employees');//$this->newEntity()->newQuery();
        if (!empty($with)) {
            $queryBuilder->with($with);
        }
        if (!empty($filter)) {
            $this->filter($queryBuilder,$filter);
        }

        if (!empty($tree)){
            $dept = Department::find($tree['nodeid']);
            $deptids = $dept->getAllChildDept()->pluck('id')->toArray();
            $queryBuilder->whereIn('bd_employees.fdept_id', $deptids);
        }

        $fields = [];
        $conditions = [];
        foreach ($columns as $column) {
            $fields[] = 'bd_employees.' . $column['data'];
            if (!empty($column['search']['value'])) {
                $conditions['bd_employees.' . $column['data']] = $column['search']['value'];
            }
        }

        $total = $queryBuilder->count();

//		$curUser = Auth::user();
//		if(!$curUser->isAdmin()) {
//			if (SysConfigRepo::isMgtDataIsolate()) {
//				$fnumbers = $curUser->positions->pluck('fnumber')->all();
//				if(!empty($fnumbers)) {
//					$queryBuilder->join('bd_positions', 'bd_employees.fpost_id', '=', 'bd_positions.id');
//					foreach ($fnumbers as $fnumber){
//						$queryBuilder->where('bd_positions.fnumber', 'like binary', $fnumber. '%');
//					}
//				}
//			}
//		}else{
//			$queryBuilder->leftJoin('bd_positions', 'bd_employees.fpost_id', '=', 'bd_positions.id');
//		}
        $queryBuilder->leftJoin('bd_positions', 'bd_employees.fpost_id', '=', 'bd_positions.id');
        $queryBuilder->leftJoin('bd_departments', 'bd_employees.fdept_id', '=', 'bd_departments.id');
        $fields[] = 'bd_positions.fname as position_name';
        $fields[] = 'bd_departments.fname as dept_name';

        foreach ($conditions as $col => $val) {
            $queryBuilder->where($col, $val);
        }

        //模糊查询
        if (!empty($searchCols) && !empty($search['value'])) {
            $queryBuilder->where(function ($query) use ($search, $searchCols) {
                foreach ($searchCols as $sc) {
                    if (is_array($sc)) {//用于其他表查询 [entity,querykey,localkey]
                        foreach ($sc as $s) {
                            $entities = $s[0]->where($s[1], 'like binary', '%' . $search['value'] . '%')->get();
                            $ids = [];
                            foreach ($entities as $e) {
                                $ids[] = $e->id;
                            }
                            $query->orWhereIn($s[2], $ids);
                        }
                    } else {
                        $query->orWhere($sc, 'like binary', '%' . $search['value'] . '%');
                    }
                }
            });

        }
        $filterCount = $queryBuilder->count();

        foreach ($order as $o) {
            $index = $o['column'];
            $dir = $o['dir'];
            $queryBuilder->orderBy($columns[$index]['data'], $dir);
        }
        if (!empty($request->distinct)) {
            $queryBuilder->groupBy($request->distinct)->distinct();
        }
        if($length > 0) {
	        $entities = $queryBuilder->select($fields)->skip($start)->take($length)->get();
        }else{
	        $entities = $queryBuilder->select($fields)->get();
        }
        $result = [
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filterCount,
            'data' => $entities
        ];
        return response()->json($result);
    }

    public function ajaxGetEmployees(Request $request)
    {
        $data = $request->all();
        $query = Employee::query();
        if (!empty($data['femp_id'])) {
            $query->where('id', $data['femp_id']);
        }
        if (!empty($data['fdept_id'])) {
            $dept = Department::find($data['fdept_id']);

            $ids = array_intersect($dept->getAllEmployeeByDept()->pluck('id')->toArray(),$this->getCurUsersEmployeeIds());
//            $query->where('fdept_id', $data['fdept_id']);
            $query->whereIn('id', $ids);
        }

        $rs = $query->get();

        return response()->json([
            'code' => 200,
            'data' => $rs
        ]);
    }

	/**
	 * 重置用户密码
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function resetPwd(Request $request, $id){
    	$emp = Employee::find($id);
    	$emp->update(['fpassword' => md5('888888')]);
	    return response()->json([
		    'code' => 200,
		    'data' => $emp
	    ]);
    }

}
