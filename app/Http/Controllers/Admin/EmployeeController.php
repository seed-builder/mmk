<?php

namespace App\Http\Controllers\Admin;

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
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = []){
		$searchCols = ['fname', 'fnumber', 'fphone'];
		return parent::pagination($request, $searchCols);
	}
	
	public function ajaxEmployeeTree(Request $request){
		$orgs = Organization::all();
		$req = $request->all();
		$datas = [];
		
		
		foreach ($orgs as $ok=>$ov){
			$pardepts = $ov->departments($ov->id);
			$par_dept = $this->toTextArray($pardepts, !empty($req['dept_select'])?true:false); //组织下的所有父部门
			
			foreach ($pardepts as $dk=>$dv){
				$childdepts = $dv->child_depart($dv->id);
				$child_dept = $this->toTextArray($childdepts, !empty($req['dept_select'])?true:false); //部门下的子部门
				
				foreach ($childdepts as $cdk=>$cdv){
					$emps = $cdv->employees()->get();
					$emp = $this->toTextArray($emps); //部门下的员工
					
					$child_dept[$cdk]['text'] = $cdv->fname;
					$child_dept[$cdk]['nodes'] = $emp;
				}
				
				$par_dept[$dk]['text'] = $dv->fname;
				$par_dept[$dk]['nodes'] = $child_dept;
				
			}
			
			$org = $this->toTextArray($orgs, false);
			$org[$ok]['nodes'] = $par_dept;
		}
			
		
		return json_encode($par_dept);
	}

	protected function toTextArray($datas, $selectable = true){
		$rs = [];
		foreach ($datas as $d){
			$rs[]=array(
				'text' => $d->fname,
				'dataid' => $d->id,
				'selectable' => $selectable
			);
		}
		
		return $rs;
	}

	public function ajaxGetEmployees(Request $request){
	    $data = $request->all();
	    $query = Employee::query();
        if (!empty($data['femp_id'])){
            $query->where('id',$data['femp_id']);
        }
	    if (!empty($data['fdept_id'])){
            $query->where('fdept_id',$data['fdept_id']);
        }

        $rs = $query->get();

	    return json_encode($rs);
    }
}
