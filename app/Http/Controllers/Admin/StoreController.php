<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\Channel;
use App\Models\Busi\Customer;
use App\Models\Busi\Department;
use App\Models\Busi\Employee;
use App\Models\Busi\StoreChange;
use App\Models\Busi\VisitLineCalendar;
use App\Models\Busi\VisitLineStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Store;
use App\Models\Busi\VisitLine;
use App\Models\City;
use App\Models\Busi\Resources;
use Image;
use Illuminate\Http\Response;
use DB;
use Auth;
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

        $store->image = '/admin/show-image?imageId=' . $store->fphoto;

        return view('admin.store.info', compact('store'));
    }

    /*
     * d调换门店
     */
    public function exchange(Request $request){
        $data = $request->all();

        Store::query()->where('femp_id',$data['old_femp_id'])->update([
            'femp_id' => $data['new_femp_id']
        ]);

        VisitLineStore::query()->where('femp_id',$data['old_femp_id'])->update([
            'femp_id' => $data['new_femp_id']
        ]);

        return response()->json([
            'code' => 200,
            'result' => '调换成功！'
        ]);
    }
}
