<?php

namespace App\Http\Controllers\Admin;

use SysConfigRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

abstract class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	//
	public abstract function newEntity(array $attributes = []);

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$data = $request->input('data', []);
		if(empty($data))
			return $this->fail('data is empty');
		$props = current($data);
		$fieldErrors = $this->validateFields($props);
		if(!empty($fieldErrors)){
			return $this->fail('validate error', $fieldErrors);
		} else {
			$entity = $this->newEntity($props);
			$entity->save();
			return $this->success($entity);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
		$data = $request->input('data', []);
		if(empty($data))
			return $this->fail('data is empty');

		$props = current($data);
		$fieldErrors = $this->validateFields($props);
		if(!empty($fieldErrors)){
			return $this->fail('validate error', $fieldErrors);
		} else {
			$entity = $this->newEntity()->newQuery()->find($id);
			$entity->fill($props);
			$entity->save();
			return $this->success($entity);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$entity =  $this->newEntity()->newQuery()->find($id);
		$entity->delete();
		$entity=[];
		return $this->success($entity);
	}

	/**
	 * Datatables UI page
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null)
	{
		$start = $request->input('start', 0);
		$length = $request->input('length', 10);
		$columns = $request->input('columns', []);
		$order = $request->input('order', []);
		$search = $request->input('search', []);
		$draw = $request->input('draw', 0);

		$queryBuilder = $this->newEntity()->newQuery();
		if (!empty($with)) {
			$queryBuilder->with($with);
		}
		$fields = [];
		$conditions = [];
		foreach ($columns as $column) {
			$fields[] = $column['data'];
			if (!empty($column['search']['value'])) {
				$conditions[$column['data']] = $column['search']['value'];
			}
		}

		$total = $queryBuilder->count();

		if($request['queryBuilder']){
			$queryBuilder = $request['queryBuilder'];
		}
		if ($conditionCall != null && is_callable($conditionCall)) {
			$conditionCall($queryBuilder);
		}
		foreach ($conditions as $col => $val) {
			$queryBuilder->where($col, $val);
		}


		//模糊查询
		if (!empty($searchCols) && !empty($search['value'])) {
			$queryBuilder->where(function ($query) use ($search, $searchCols) {
				foreach ($searchCols as $sc) {
					$query->orWhere($sc, 'like binary', '%' . $search['value'] . '%');
//					if (is_array($sc)) {//用于其他表查询 [entity,querykey,localkey]
//						foreach ($sc as $s) {
//							$entities = $s[0]->where($s[1], 'like binary', '%' . $search['value'] . '%')->get();
//							$ids = [];
//							foreach ($entities as $e) {
//								$ids[] = $e->id;
//							}
//							$query->orWhereIn($s[2], $ids);
//						}
//					} else {
//						$query->orWhere($sc, 'like binary', '%' . $search['value'] . '%');
//					}
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
		$entities = $queryBuilder->select($fields)->skip($start)->take($length)->get();
		//var_dump($queryBuilder->toSql());
		$result = [
			'draw' => $draw,
			'recordsTotal' => $total,
			'recordsFiltered' => $filterCount,
			'data' => $entities
		];
		return response()->json($result);
	}

	protected function validateFields($data)
	{
		$fieldErrors = [];
		$entity= $this->newEntity();
		if(isset($entity->validateRules)) {
			$validator = Validator::make($data, $entity->validateRules);
			if ($validator->fails()) {
				$errors = $validator->errors();
				$keys = $errors->keys();
				foreach ($keys as $k) {
					$fieldErrors[] = ['name' => $k, 'status' => $errors->first($k)];
				}
			}
		}
		return $fieldErrors;
	}

	public function success($data){
		return response()->json(['data' => [$data]]);
	}

	public function fail($error, $fieldErrors = []){
		return response()->json(['data' => [], 'error' =>  $error, 'cancelled' => 1, 'fieldErrors' => $fieldErrors]);
	}

	public function flash_success($msg){
		Session::flash('success', $msg);
	}

	public function flash_alert($msg){
		Session::flash('message', $msg);
	}

	public function flash_error($msg){
		Session::flash('error', $msg);
	}

	/**
	 * 将实体数据转换成树形（bootstrap treeview）数据
	 * @param $entity
	 * @param $props 属性映射集合 ['text' => 'name', 'data-id' => 'id']
	 * @param bool $expanded
	 * @return array
	 */
	public function toBootstrapTreeViewData($entity, $props, $expanded = true){
		$data = ['item' => $entity];
		if(!empty($entity)){
			foreach ($props as $k => $val){
				$data[$k] = $entity->{$val};
				$data['state']['expanded'] = $expanded;
			}

			if(!empty($entity->children)){
				$nodes = [];
				foreach ($entity->children as $child){
					$nodes[] = $this->toBootstrapTreeViewData($child, $props, $expanded);
				}
				if(!empty($nodes))
					$data['nodes'] = $nodes;
			}
		}
		return $data;
	}

	/**
	 *
	 * @param $entity
	 * @param $props
	 * @param $options
	 * @param string $prefix
	 */
	public function toSelectOption($entity, $props, &$options, $prefix = '|--'){
		//$options = [];
		if(!empty($entity)) {
			$data= [];
			foreach ($props as $k => $val) {
				if($k == 'label'){
					$data[$k] = $prefix . ' ' .$entity->{$val};
				}else{
					$data[$k] = $entity->{$val};
				}
			}
			$options[] = $data;
			if(!empty($entity->children)){
				foreach ($entity->children as $child){
					$this->toSelectOption($child, $props, $options, $prefix . '-----|--');
				}
			}
		}
		//return $options;
	}

	/*
	 * 审核
	 */
	public function check(Request $request){
	    $data = $request->all();
	    $ids = explode(",",$data['ids']);
        $entitys = $this->newEntity()->newQuery()->whereIn('id',$ids)->get();

        foreach ($entitys as $entity){
            $entity->fdocument_status="B";

            $entity->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '审核成功！'
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

            $entity->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '反审核成功！'
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
	    if(!$curUser->isAdmin()) {
		    if (SysConfigRepo::isMgtDataIsolate()) {
			    $flags = $curUser->positions->pluck('flag')->all();
			    if(!empty($flags)) {
				    $empQuery->join('bd_positions', 'bd_employees.fpost_id', '=', 'bd_positions.id');
				    foreach ($flags as $flag){
					    $empQuery->orWhere('bd_positions.flag', 'like', $flag. '%');
				    }
			    }
		    }
	    }
	    $entities = $empQuery->select('bd_employees.id')->get();
	    $ids = $entities->pluck('id')->all();
	    return $ids;
    }
}
