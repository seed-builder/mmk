<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\Employee;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Store;
use Illuminate\Database\Eloquent\Builder;
use DB;

class StoreController extends ApiController
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $entity = Store::find($id);
        if(!empty($entity->customer)){
            $entity->customer_name = $entity->customer->fname;
        }
        return response($entity, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();
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
        unset($data['_sign']);
        $entity = $this->newEntity($data);
        //$entity = Entity::create($data);
        $re = $entity->save();
        $status = $re ? 200 : 400;
        return response($entity, $status);
    }

    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new Store($attributes);
    }

	public function fillQueryForIndex(Request $request, Builder &$query){
		$search = $request->input('search', '{}');
		$conditions = json_decode($search, true);
		if(!empty($conditions)) {
			//dump($conditions);
			foreach ($conditions as $k => $v) {
				$tmp = explode(' ', $k);
				if($tmp[0] == 'femp_id'){
					$fempId = $v;
					$repo = app(ISysConfigRepo::class);
					if($repo->isAppDataIsolate()) {
						$employee = Employee::find($fempId);
						if ($employee->isDataIsolate()) {
							$subs = $employee->getSubordinates();
							$ids = [];
							if (!empty($subs)) {
								$ids = array_map(function ($item) use ($ids) {
									return $item->id;
								}, $subs);
							}
							$ids[] = $fempId;
							$query->whereIn('femp_id', $ids);
						}
					}
				}else {
					$query->where($tmp[0], isset($tmp[1]) ? $tmp[1] : '=', $v);
				}
			}
		}
		//return $query;
	}

	/**
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function noSignedList(Request $request, $femp_id){

		$sql = 'select st.* from st_stores st where not EXISTS (select * from exp_display_policy_store ep where st.id = ep.fstore_id)';
		if($femp_id) {
			$employee = Employee::find($femp_id);
			$subs = $employee->getSubordinates();
			$ids = [];
			if(!empty($subs)){
				$ids = array_map(function ($item)use($ids){
					return $item->id;
				}, $subs);
			}
			$ids[] = $femp_id;
			$sql = $sql . ' and st.femp_id in( '.implode(',', $ids).' )';
		}
		$stores = DB::select($sql);
		return response($stores, 200);
	}

}
