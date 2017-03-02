<?php

namespace App\Http\Controllers\Admin;

use App\Services\DataSync\DefaultFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Employee;
use App\Models\Busi\Organization;
use Swagger\Annotations\Items;
use App\Models\Busi\Department;

class EmployeeController extends AdminController
{

    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Employee($attributes);
	}

	public function index()
	{
		$all = Organization::all();
		$orgs = $all->map(function ($item){
			return ['label' => $item->fname, 'value' => $item->id];
		});
		
		return view('admin.employee.index',compact('orgs'));
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null){
		$searchCols = ['fname', 'fnumber', 'fphone'];
		$data = $request->all();
		return parent::pagination($request, $searchCols, $with, function($queryBuilder)use($data){
			if(!empty($data['nodeid'])){//组织树点击查询
				$dept = Department::find($data['nodeid']);
				$deptids = $dept->getAllChildDept()->pluck('id')->toArray();

				$queryBuilder->whereIn('fdept_id',$deptids);
			}
		});
	}

    public function employeeTree(){
		$top = Department::where('fpardept_id', 0)->first();
		$tree = $this->toBootstrapTreeViewData($top,  ['text' => 'fname', 'dataid' => 'id'], false);
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
	public function toBootstrapTreeViewData($entity, $props, $expanded = true){
		$data = ['item' => $entity];
		if(!empty($entity)){
			foreach ($props as $k => $val){
				$data[$k] = $entity->{$val};
				$data['icon'] = 'fa fa-users';
				$data['state'] = ['expanded' => $expanded];
				$data['nodetype'] = 'dept';
			}
			$nodes = [];
			if(!empty($entity->children)){
				foreach ($entity->children as $child){
					$nodes[] = $this->toBootstrapTreeViewData($child, $props, $expanded);
				}
			}
			//find employee
			if(!empty($entity->employees)){
				foreach ($entity->employees as $employee){
					$nodes[] = [
						'text' => $employee->fname,
						'dataid' => $employee->id,
						'icon' => 'fa fa-user',
                        'nodetype' => 'emp',
					];
				}
			}
			if(!empty($nodes))
				$data['nodes'] = $nodes;
		}
		return $data;
	}
}
