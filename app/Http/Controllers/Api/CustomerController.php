<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Customer;
use Illuminate\Database\Eloquent\Builder;

class CustomerController extends ApiController
{
    //

    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new Customer($attributes);
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
					$employee = Employee::find($fempId);
					$subs = $employee->getSubordinates();
					$ids=[];
					//var_dump($subs);
					if(!empty($subs)){
						$ids = array_map(function ($item)use($ids){
							return $item->id;
						}, $subs);
					}
					$ids[] = [$fempId];
					//var_dump($ids);
					$query->distinct();
					$query->select('bd_customers.*');
					$query->join('st_stores', 'bd_customers.id', '=', 'st_stores.fcust_id');
					$query->whereIn('st_stores.femp_id', $ids);
				}else {
					$query->where($tmp[0], isset($tmp[1]) ? $tmp[1] : '=', $v);
				}
			}
		}
		//return $query;
	}

}
