<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\Store;
use App\Models\Busi\VisitPzbz;
use App\Models\Busi\VisitStoreTodo;
use App\Models\Busi\VisitTodoCalendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\Employee;
use App\Models\Busi\Department;

class VisitStoreCalendarController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new VisitStoreCalendar($attributes);
	}
	
	public function index()
	{
		return view('admin.visit_store_calendar.index');
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = true){
		$searchCols = ['fdate', 'forg_id','femp_id','fstore_id','fstatus','fline_calendar_id'];

		return parent::pagination($request, $searchCols, $with, function ($queryBuilder){
			$ids = $this->getCurUsersEmployeeIds();
			//var_dump($ids);
			if(!empty($ids))
			{
				$queryBuilder->whereIn('femp_id', $ids);
			}
		},$all_columns);
	}

	public function visitStoreCalendarInfo($id){
        $todos = VisitTodoCalendar::query()->where('fstore_calendar_id',$id)->get();
        $sc = VisitStoreCalendar::find($id);

        foreach ($todos as $t){
            $pzs = VisitPzbz::where('flog_id', $t->id)->first();

            if (!empty($pzs)){
                $imageIds=explode(",", $pzs->fphotos);

                $images = [];
                foreach ($imageIds as $i){
                    $images[] = '/admin/show-image?imageId='.$i;
                }
                $t->images = $images;
            }
        }


        return view('admin.visit_store_calendar.info',compact('todos','sc'));
    }

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
                default : {
                    $queryBuilder=$this->adminFilterQuery($queryBuilder,$f);
                }
            }
        }
    }
}
