<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\DatatablesController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends DatatablesController
{
    //
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
	}

    /*
     * 审核
     */
    public function check(Request $request){
        $data = $request->all();
        $ids = explode(",",$data['ids']);
        $entitys = $this->newEntity()->newQuery()->whereIn('id',$ids)->get();

        foreach ($entitys as $entity){
            $entity->fdocument_status="C";

            $entity->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '审核成功！',
            'data' => $entitys
        ]);
    }

    /*
     * 反审核
     */
    public function unCheck(Request $request){
        $data = $request->all();
        $ids = explode(",",$data['ids']);
        $entitys = $this->newEntity()->newQuery()->whereIn('id',$ids)->get();

        foreach ($entitys as $entity){
            $entity->fdocument_status="A";

            $entity->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '反审核成功！',
            'data' => $entitys
        ]);
    }
}
