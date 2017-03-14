<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Department;
use App\Models\Busi\Organization;

class DepartmentController extends AdminController
{

    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Department($attributes);
	}

	public function index()
	{
		$all = Organization::all();
		$orgs = $all->map(function ($item){
			return ['label' => $item->fname, 'value' => $item->id];
		});
		return view('admin.department.index',compact('orgs'));
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false){
		$searchCols = ['fname', 'ffullname', 'fnumber'];
		return parent::pagination($request, $searchCols);
	}

	public function ajaxGetDepart(Request $request){
		dd($request->all());
	}

    public function departmentTree(){
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

            if(!empty($nodes))
                $data['nodes'] = $nodes;
        }
        return $data;
    }
}
