<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Department;
use App\Models\Busi\DisplayPolicy;
use App\Models\Busi\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\DisplayPolicyStore;

class DisplayPolicyStoreController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new DisplayPolicyStore($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.display-policy-store.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.display-policy-store.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = DisplayPolicyStore::find($id);
		return view('admin.display-policy-store.edit', ['entity' => $entity]);
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
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
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$searchCols = ["fbill_no","fdocument_status","fsketch"];
        $with=['department','employee','policy','store'];
        $data = $request->all();
        if(!empty($data['nodeid'])){//组织树点击查询
            $query = DisplayPolicyStore::query();
            $dept = Department::find($data['nodeid']);
            $deptids = $dept->getAllChildDept()->pluck('id')->toArray();

            $request['queryBuilder'] = $query->whereIn('fcost_dept_id',$deptids)->with($with);;
        }
		return parent::pagination($request, $searchCols,$with);
	}

	public function check(Request $request)
    {
        $data = $request->all();

        $entity = DisplayPolicyStore::find($data['id']);
        $entity->fdocument_status="C";
        $entity->fcheck_amount = $data['fcheck_amount'];
        $entity->status = 1;

        $policy = DisplayPolicy::find($entity->fpolicy_id);

        if($policy->fstore_cost_limit<$entity->fcheck_amount){//核定签约金额大于方案费用上限
            return response()->json([
                'code' => 500,
                'result' => '核定签约金额大于方案费用上限，审核失败！'
            ]);
        }

        if(($policy->famount-$policy->fsign_amount)<$entity->fcheck_amount){//核定签约金额大于所剩余的能签约的金额
            return response()->json([
                'code' => 500,
                'result' => '核定签约高于所剩余金额，审核失败！'
            ]);
        }

        $policy->fsign_amount = $policy->fsign_amount+$entity->fcheck_amount;
        $policy->fsign_store_num = $policy->fsign_store_num+1;

//        Store::query()->where('id',$entity->fstore_id)->update([
//            'fis_signed' => 1
//        ]);
        $entity->save();
        $policy->save();

        return response()->json([
            'code' => 200,
            'result' => '审核成功！'
        ]);

    }

    public function unCheck(Request $request)
    {
        $json = parent::unCheck($request);
        $data = json_decode($json->content())->data; // TODO: Change the autogenerated stub

        foreach ($data as $d){
            DisplayPolicyStore::query()->where('id',$d->id)->update([
                'fcheck_amount' => 0
            ]);
            Store::query()->where('id',$d->fstore_id)->update([
                'fis_signed' => 0
            ]);
            $policy = DisplayPolicy::find($d->fpolicy_id);
            $policy->fsign_amount = $policy->fsign_amount-$d->fcheck_amount;
            $policy->fsign_store_num = $policy->fsign_store_num-1;
            $policy->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '反审核成功！'
        ]);
    }

}
