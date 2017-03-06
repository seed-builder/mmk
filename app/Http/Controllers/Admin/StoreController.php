<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\Channel;
use App\Models\Busi\Customer;
use App\Models\Busi\Department;
use App\Models\Busi\Employee;
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
        $citys = City::query()->where('LevelType',1)->get();
        $channels = Channel::all();
        $cus = Customer::all();
		return view('admin.store.index',compact('citys','channels','cus'));
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null){
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

		return parent::pagination($request, $searchCols, $with, function ($queryBuilder){
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
			$ids = $entities->pluck('id')->all(); //array_map(function ($item){	return $item->id;}, $entities);
			//var_dump($ids);
			if(!empty($ids))
			{
				$queryBuilder->whereIn('femp_id', $ids);
			}
		});
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


    //门店添加
    public function createStore(Request $request){
        $result = $this->saveData($request->all(),'create');

        return response()->json($result);
    }

    //门店编辑
    public function editStore(Request $request){
        $result = $this->saveData($request->all(),'edit');

        return response()->json($result);
    }

    //数据保存
    public function saveData($data,$action){

        //图片保存
        if (!empty($data['storephoto'])){
            //$file = $request->file('storephoto');
            $file = $data['storephoto'];
            //var_dump($file);
            if($file->isValid())
            {
                $path = $file->store('upload/images');
                if($path){
                    $res = Resources::create([
                        'name' => $file->getClientOriginalName(),
                        'ext' => $file->getClientOriginalExtension(),
                        'size' => $file->getSize(),
                        'path' => 'app/' . $path ,
                        'mimetype' => $file->getMimeType(),
                    ]);
                    $data['fphoto'] = $res->id;
                }
            }
        }

        //数据处理

        $data['fprovince'] = City::find($data['fprovince'])->Name;
        $data['fcity'] = City::find($data['fcity'])->Name;
        $data['fcountry'] = City::find($data['fcountry'])->Name;

        $postalcode = City::getPostalCode($data['fprovince'], $data['fcity'], $data['fcountry']);
        if($postalcode){
            $fn = Store::where('fpostalcode', $postalcode)->max('fnumber');
            if($fn){
                $fn++;
                $data['fnumber'] = $fn;
            }else{
                $data['fnumber'] = $postalcode . sprintf('%05d', 1);
            }
            $data['fpostalcode'] = $postalcode;
        }
        unset($data['_token'],$data['storephoto']);

        if ($action=='create'){
            $entity = $this->newEntity($data);
            //$entity = Entity::create($data);
            $re = $entity->save();

            if ($re){
                return [
                    'code' => 200,
                    'result' => '添加门店成功！'
                ];
            }else{
                return [
                    'code' => 500,
                    'result' => '添加门店失败！'
                ];
            }
        }else {
            $re = Store::query()->where('id',$data['id'])->update($data);

            if ($re){
                return [
                    'code' => 200,
                    'result' => '修改门店成功！'
                ];
            }else{
                return [
                    'code' => 500,
                    'result' => '修改门店失败！'
                ];
            }
        }


    }

    //获取门店信息
    public function getStore($id){
        $store = Store::find($id);

        $store->image = '/admin/show-image?imageId='.$store->fphoto;
        return response()->json($store);
    }

    //获取门店信息
    public function storeInfo($id){
        $store = Store::find($id);

        $store->image = '/admin/show-image?imageId='.$store->fphoto;

        return view('admin.store.info',compact('store'));
    }
}
