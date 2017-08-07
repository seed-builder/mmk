<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\Channel;
use App\Models\Busi\Customer;
use App\Models\Busi\Department;
use App\Models\Busi\Employee;
use App\Models\Busi\StoreChange;
use App\Models\Busi\VisitLineCalendar;
use App\Models\Busi\VisitLineStore;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\VisitTodoCalendar;
use App\Services\ExcelService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Store;
use App\Models\Busi\VisitLine;
use App\Models\City;
use App\Models\Busi\Resources;
use Illuminate\Support\Facades\DB;
use Image;
use Illuminate\Http\Response;
use Auth;
use Mockery\Exception;
use SysConfigRepo;
use App\Services\LogSvr;

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
        $citys = City::query()->where('LevelType', 1)->get();
        $channels = Channel::all();
        $cus = Customer::all();
        $lines = VisitLine::all();

        $employees = Employee::query()->whereIn('id',$this->getCurUsersEmployeeIds())->get();
        return view('admin.store.index', compact('citys', 'channels', 'cus','lines','employees'));
    }

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
    {
        $searchCols = ['fnumber', 'ffullname', 'fshortname', 'faddress', 'fcontracts'];

        $data = $request->all();

        return parent::pagination($request, $searchCols, ['employee','customer','line','channel'], function ($queryBuilder) use ($data,$request) {

            $this->readyAllotStoreQuery($data,$queryBuilder);

            $ids = $this->getCurUsersEmployeeIds();//$entities->pluck('id')->all(); //array_map(function ($item){	return $item->id;}, $entities);
	        //LogSvr::store()->info(json_encode($ids));
            if (!empty($ids)) {
                $queryBuilder->whereIn('femp_id', $ids);
            }
        });
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
                default : {
                    $queryBuilder=$this->adminFilterQuery($queryBuilder,$f);
                }
            }
        }
    }

    //门店路线规划 预分配门店查询
    public function readyAllotStoreQuery($data,$query)
    {
        if (!empty($data['femp_id'])){
            $query->where('femp_id', $data['femp_id']);

            //预分配门店列表 过滤掉该线路中已存在的门店
            $exist_ids = VisitLineStore::query()->where('fline_id', $data['fline_id'])->pluck('fstore_id')->toArray();
            $query->whereNotIn('id', $exist_ids);
        }

        if (!empty($data['fname'])) {
            $query->where('ffullname', 'like', '%' . $data['fname'] . '%')->get();
        }
        if (!empty($data['faddress'])) {
            $query->where('faddress', 'like', '%' . $data['faddress'] . '%')->get();
        }

        if (!empty($data['fnumber'])) {
            $line_ids = VisitLine::query()->where('fnumber', 'like', '%' . $data['fnumber'] . '%')->pluck('id')->toArray();
            $vls_ids = VisitLineStore::query()->where('femp_id', $data['femp_id'])->whereIn('fline_id', $line_ids)->pluck('id')->toArray();

            $query->whereIn('id', $vls_ids);
        }
        if (!empty($data['is_allot'])) {
            $ids = VisitLineStore::query()->where('femp_id', $data['femp_id'])->pluck('fstore_id')->toArray();

            if ($data['is_allot'] == 1) {
                $query->whereIn('id', $ids);
            } else if ($data['is_allot'] == 2) {
                $query->whereNotIn('id', $ids);
            }
        }

    }

    //自定义查询
    public function diyquery(Request $request)
    {
        $data = $request->all();
        $query = Store::query();
        //预分配门店列表 过滤掉该线路中已存在的门店
        $ids1 = VisitLineStore::query()->where('fline_id', $data['fline_id'])->pluck('fstore_id')->toArray();

        $query->whereNotIn('id', $ids1);

        if (!empty($data['fprovince'])) {
            $query->where('fprovince', $data['fprovince']);
        }
        if (!empty($data['fcity'])) {
            $query->where('fcity', $data['fcity']);
        }
        if (!empty($data['fcountry'])) {
            $query->where('fcountry', $data['fcountry']);
        }
        if (!empty($data['femp_id'])) {
            $query->where('femp_id', $data['femp_id']);
        }

        $query->with(['employee']);

        return response()->json($query->get());
    }

    //门店添加
    public function createStore(Request $request)
    {
        $result = $this->saveData($request->all(), 'create');

        return response()->json($result);
    }

    //门店编辑
    public function editStore(Request $request)
    {
        $result = $this->saveData($request->all(), 'edit');

        return response()->json($result);
    }

    //数据保存
    public function saveData($data, $action)
    {
        //图片保存
        if (!empty($data['storephoto'])) {
            //$file = $request->file('storephoto');
            $file = $data['storephoto'];
            //var_dump($file);
            if ($file->isValid()) {
                $path = $file->store('upload/images');
                if ($path) {
                    $res = Resources::create([
                        'name' => $file->getClientOriginalName(),
                        'ext' => $file->getClientOriginalExtension(),
                        'size' => $file->getSize(),
                        'path' => 'app/' . $path,
                        'mimetype' => $file->getMimeType(),
                    ]);
                    $data['fphoto'] = $res->id;
                }
            }
        }
        unset($data['_token'], $data['storephoto']);
        if ($action == 'create') {
	        $data['fdocument_status'] = 'A';//未经审批，禁用
	        $data['fforbid_status'] = 'B';//未经审批，禁用
	        $data['fcreator_id'] = Auth::user()->id;
            $entity = $this->newEntity($data);
            //$entity = Entity::create($data);
            $re = $entity->save();
	        //创建变更单
	        StoreChange::addFromStore($entity->toArray(), 0, '新增门店');

            if ($re) {
                return [
                    'code' => 200,
                    'result' => '添加门店成功！'
                ];
            } else {
                return [
                    'code' => 500,
                    'result' => '添加门店失败！'
                ];
            }
        } else {
        	$store = Store::find($data['id']);
        	$data['fmodify_id'] =  Auth::user()->id;
        	$store->fill($data);

	        $re = StoreChange::addFromStore($store->toArray(), 1, '修改门店');
	        //$re = $store->save();
//            $re = Store::query()->where('id', $data['id'])->update($data);

            if ($re) {
                return [
                    'code' => 200,
                    'result' => '门店修改变更提交成功，请等待审批！'
                ];
            } else {
                return [
                    'code' => 500,
                    'result' => '修改门店失败！'
                ];
            }
        }


    }

    //获取门店信息
    public function getStore($id)
    {
        $store = Store::find($id);

        $store->image = '/admin/show-image?imageId=' . $store->fphoto;

        return response()->json([
            'code' => 200,
            'result' => 'success',
            'data' => $store
        ]);
    }

    //获取门店信息
    public function storeInfo($id)
    {
        $store = Store::find($id);
		if(!empty($store))
            $store->image = '/admin/show-image?imageId=' . $store->fphoto;

        return view('admin.store.info', compact('store'));
    }

	/**
	 * 禁用门店
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function forbidden(Request $request){
	    $ids = $request->input('ids', []);
	    $re = Store::whereIn('id', $ids)->update(['fmodify_id' => Auth::user()->id, 'fforbid_status' => 'B']);
	    //$re = StoreChange::addFromStore($store->toArray(), 3, '禁用门店');
	    return $this->success($re);
    }

	/**
	 * 反禁用门店
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function start_use(Request $request){
		$ids = $request->input('ids', []);
		$affected = Store::whereIn('id', $ids)->update(['fmodify_id' => Auth::user()->id, 'fforbid_status' => 'A']);

//		$ids = $request->input('ids', []);
//		$affected = DB::update('update st_stores set fforbid_status = ? where id = ?', ['A', $id]);
		return $this->success($affected);
	}

	public function batch_remove(Request $request){
		$ids = $request->input('ids', []);
		$res = Store::whereIn('id', $ids)->delete();
		return $this->success($res);
	}

    /*
     * d调换门店
     */
    public function exchange(Request $request){
        $data = $request->all();

	    DB::beginTransaction();
	    try {
		    Store::query()->where('femp_id', $data['old_femp_id'])->update([
			    'femp_id' => $data['new_femp_id']
		    ]);

		    VisitLineStore::query()->where('femp_id', $data['old_femp_id'])->update([
			    'femp_id' => $data['new_femp_id']
		    ]);

		    $yesterday = date('Y-m-d', strtotime('-1 day'));
		    VisitLineCalendar::where('femp_id', $data['old_femp_id'])
			    ->where('fcreate_date', '>', $yesterday)
			    ->update([
				    'femp_id' => $data['new_femp_id']
			    ]);
		    VisitStoreCalendar::where('femp_id', $data['old_femp_id'])
			    ->where('fcreate_date', '>', $yesterday)
			    ->update([
				    'femp_id' => $data['new_femp_id']
			    ]);
		    VisitTodoCalendar::where('femp_id', $data['old_femp_id'])
			    ->where('fcreate_date', '>', $yesterday)
			    ->update([
				    'femp_id' => $data['new_femp_id']
			    ]);
		    DB::commit();

		    return response()->json([
			    'code' => 200,
			    'result' => '调换成功！'
		    ]);
	    }catch (Exception $exception){
		    DB::rollBack();
		    return response()->json([
			    'code' => 400,
			    'result' => '调换失败！'
		    ]);
	    }
    }

    public function initFilter($queryBuilder, $data)
    {
        if (!empty($data['femp_id']))
            $queryBuilder->where('femp_id', $data['femp_id']);

        return $queryBuilder;
    }

    public function storeChangeIndex(){
        $lines = VisitLine::all();

        return view('admin.store.store-change', compact('lines'));
    }

    public function storeChange(Request $request){
        $store_ids = $request->input('store_ids',[]);
        $user_id = $request->input('user_id',0);

        $stores = $this->newEntity()->newQuery()->whereIn('id',$store_ids)->get();

        foreach ($stores as $store){
            $store->femp_id = $user_id;
            $store->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '调换门店成功'
        ]);
    }

	public function export($datas)
	{
		$data = [['门店编码', '门店全称', '详细地址', '负责人', '联系电话', '负责业代', '经销商', '路线','渠道','是否签约','审核状态']];
		foreach ($datas as $d) {
			$status = "无";
			switch ($d->fdocument_status){
				case 'A':
					$status= '未审核';
					break;
				case 'C':
					$status= '已审核';
					break;
				case 'B':
					$status= '审核中';
					break;

			}
			$signed = $d->fis_signed ? '是':'否';

			$data[] = [
				$d->fnumber,
				$d->ffullname,
				$d->faddress,
				$d->fcontracts,
				$d->ftelephone,
				$d->employee ? $d->employee->fname : '',
				$d->customer ? $d->customer->fname : '',
				$d->line ? $d->line->fname : '',
				$d->channel ? $d->channel->fname : '',
				$signed,
				$status
			];
		}

		$excel = new ExcelService();
		$excel->export($data, date('Ymd') . '_门店信息');
	}

	public function exportExcel(Request $request, $with = [], $conditionCall = null)
	{
		$data = $request->all();
		parent::exportExcel($request,  ['employee','customer','line','channel'], function ($queryBuilder) use ($data,$request) {

			$this->readyAllotStoreQuery($data,$queryBuilder);

			$ids = $this->getCurUsersEmployeeIds();//$entities->pluck('id')->all(); //array_map(function ($item){	return $item->id;}, $entities);
			//LogSvr::store()->info(json_encode($ids));
			if (!empty($ids)) {
				$queryBuilder->whereIn('femp_id', $ids);
			}
		}); // TODO: Change the autogenerated stub
	}

}
