<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\DatatablesController;
use SysConfigRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use App\Services\LogSvr;

abstract class AdminController extends DatatablesController
{
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

	/**
	 * 获取当前登陆用户所能操作的员工id 集合
	 * @return mixed
	 */
    public function getCurUsersEmployeeIds()
    {
	    $empQuery = DB::table('bd_employees');//,[[$emp,'fname','femp_id']]
	    $curUser = Auth::user();
	    if(!$curUser->isAdmin()) {
		    if (SysConfigRepo::isMgtDataIsolate()) {
			    $flags = $curUser->positions->pluck('flag')->all();
			    if(!empty($flags)) {
				    $empQuery->join('bd_positions', 'bd_employees.fpost_id', '=', 'bd_positions.id');
//				    foreach ($flags as $flag){
//					    $empQuery->orWhere('bd_positions.flag', 'like', $flag. '%');
//				    }
				    $empQuery->where(function ($empQuery) use ($flags){
					    foreach ($flags as $flag){
						    $empQuery->orWhere('bd_positions.flag', 'like', $flag. '%');
					    }
				    });
			    }
		    }
	    }
	    $entities = $empQuery->select('bd_employees.id')->get();
	    $ids = $entities->pluck('id')->all();
	    return $ids;
    }
}
