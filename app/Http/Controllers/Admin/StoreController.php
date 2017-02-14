<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\Department;
use App\Models\Busi\Employee;
use App\Models\Busi\VisitLineStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Store;
use App\Models\Busi\VisitLine;
use Illuminate\Http\Response;

class StoreController extends AdminController
{

    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Store($attributes);
	}

	public function index()
	{
		return view('admin.store.index');
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = []){
		$searchCols = ['fnumber', 'ffullname', 'fshortname','faddress','fcontracts'];

        $data = $request->all();
        $query = Store::query();
        foreach ($data['columns'] as $d) {
            if ($d['data']=='femp_id'&&!empty($d['search']['value'])){
                $emp = Employee::find($d['search']['value']);
                if (empty($emp)){
                    $dept = Department::find($d['search']['value']);
                    $emp_ids = $dept->getAllEmployeeByDept()->pluck('id')->toArray();

                    $query->whereIn('femp_id',$emp_ids);
                }else{
                    $query->where('femp_id',$d['search']['value']);
                }


                $request['queryBuilder'] = $query;
            }
        }

        //门店路线规划 预分配门店查询
        if (!empty($data['fname'])||!empty($data['faddress'])||!empty($data['fnumber'])||!empty($data['is_allot'])){
            $request['queryBuilder']=$this->readyAllotStoreQuery($data);
        }

		return parent::pagination($request, $searchCols);
	}

    //门店路线规划 预分配门店查询
    public function readyAllotStoreQuery($data){
        $query = Store::query();
        $query->where('femp_id',$data['femp_id']);

        //预分配门店列表 过滤掉该线路中已存在的门店
        $exist_ids = VisitLineStore::query()->where('fline_id',$data['fline_id'])->pluck('fstore_id')->toArray();
        $query->whereNotIn('id',$exist_ids);

        if (!empty($data['fname'])){
            $query->where('ffullname','like','%'.$data['fname'].'%')->get();
        }
        if (!empty($data['faddress'])){
            $query->where('faddress','like','%'.$data['faddress'].'%')->get();
        }

        if (!empty($data['fnumber'])){
            $line_ids = VisitLine::query()->where('fnumber','like','%'.$data['fnumber'].'%')->pluck('id')->toArray();
            $vls_ids = VisitLineStore::query()->where('femp_id',$data['femp_id'])->whereIn('fline_id',$line_ids)->pluck('id')->toArray();

            $query->whereIn('id',$vls_ids);
        }
        if (!empty($data['is_allot'])){
            $ids = VisitLineStore::query()->where('femp_id',$data['femp_id'])->pluck('fstore_id')->toArray();

            if ($data['is_allot']==1){
                $query->whereIn('id',$ids);
            }else if ($data['is_allot']==2){
                $query->whereNotIn('id',$ids);
            }
        }

        return $query;
    }

    //自定义查询
    public function diyquery(Request $request){
        $data = $request->all();
        $query = Store::query();
        //预分配门店列表 过滤掉该线路中已存在的门店
        $ids1 = VisitLineStore::query()->where('fline_id',$data['fline_id'])->pluck('fstore_id')->toArray();

        $query->whereNotIn('id',$ids1);

        if (!empty($data['fprovince'])){
            $query->where('fprovince',$data['fprovince']);
        }
        if (!empty($data['fcity'])){
            $query->where('fcity',$data['fcity']);
        }
        if (!empty($data['fcountry'])){
            $query->where('fcountry',$data['fcountry']);
        }
        if (!empty($data['femp_id'])){
            $query->where('femp_id',$data['femp_id']);
        }

        return json_encode($query->get());
    }

}
