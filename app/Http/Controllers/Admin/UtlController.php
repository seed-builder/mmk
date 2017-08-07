<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\Customer;
use App\Services\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Response;
use Image;
use App\Models\ModelMap;
use App\Models\Busi\Resources;
use Log;
use DB;
use App\Services\KingdeeSyncData;

class UtlController extends Controller
{
    //
    public function uploadImage(Request $request){
        $file = $request->file('imageFile');
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
            }
        }
        return response($res, 200);
    }

    public function showImage(Request $request){
        $id = $request->input('imageId');
        $h = $request->input('h', null);
        $w = $request->input('w', null);
        $image = Resources::find($id); //'
        $image = storage_path($image->path);
        if(!empty($image)) {
	        $img = Image::make($image);
	        if ($h || $w) {
		        $img->resize($w, $h);
	        }
	        return $img->response();
        }else{
        	return response('not image', 404);
        }
    }

	public function uploadFile(Request $request){
        $file = $request->file('sourceFile');
        //var_dump($file);
        if($file->isValid())
        {
            $path = $file->store('upload/message-files');
            if($path){
                $res = Resources::create([
                    'name' => $file->getClientOriginalName(),
                    'ext' => $file->getClientOriginalExtension(),
                    'size' => $file->getSize(),
                    'path' => 'app/' . $path ,
                    'mimetype' => $file->getMimeType(),
                ]);
            }
        }
        return response()->json([
            'data' => $res->id
        ]);

	}

	public function downloadFile(Request $request){
		$id = $request->input('id');
		$file = Resources::find($id); //'
		if(!empty($file)) {
			$path = storage_path($file->path);
			return response()->download($path, $file->name, ['Content-Type' => $file->mimetype]);
		}else{
			return response('has no file', 200);
		}
	}

	public function sendData(Request $request){
		$table = $request->input('table');
		$op = $request->input('op', 0);
		$condition = $request->input('condition');
		$query = "select * from $table where $condition ";
		$result = DB::select($query);
		//var_dump($query);
		$arr = [];
		if(!empty($result)){
			$sync = new KingdeeSyncData();
			foreach ($result as $model){
				$res = $sync->sync($table, $op, $model);
				$arr[] = ['data' => $model, 'response' => $res];
			}
		}
		return response($arr, 200);
	}

	/**
     * 数据库同步
     * @param Request $request
     * @return Response
     */
    public function syncDB2(Request $request){
        $table = $request->input('table');
        $op = $request->input('op');
        $data = json_decode( $request->input('data', '') , true );
        $affected = 0;
        if(!empty($data) && !empty($table)) {
            $columns = [];
            $values = [];
            //0-新增， 1-修改， 2-删除
            switch ($op) {
                default:
                case 0:
                    $patten = [];
                    foreach ($data as $col => $val){
                        $columns[] = "`$col`";
                        $values[] = $val;
                        $patten[] = '?';
                    }
                    $query = 'insert into '.$table.' ('. implode(',', $columns) .') values ('.implode(',',$patten).')';
                    $affected = DB::insert($query, $values);
                    break;
                case 1:
                    $where = 'id=';
                    foreach ($data as $col => $val){
                        if($col == 'id'){
                            $where .= $val;
                            continue;
                        }
                        $columns[] = "`$col`" . '=?' ;
                        $values[] = $val;
                    }
                    $affected = DB::update('update '.$table.' set '.implode(',', $columns).' where ' . $where, $values);
                    break;
                case 2:
                    foreach ($data as $col => $val){
                        $columns[] = "`$col`" . '=?' ;
                        $values[] = $val;
                    }
                    $affected = DB::delete('delete from ' . $table . ' where ' . implode(' and ', $columns), $values);
                    break;
                case 3:
                    $affected = DB::delete('delete from ' . $table );
                    break;

            }
        }

        return response(['affected' => $affected], 200);
    }

    public function syncDB(Request $request){
	    $table = $request->input('table');
	    $op = $request->input('op');
	    $data = json_decode( $request->input('data', '') , true );
	    $affected = 1;
	    $dataSync = app('dataSync');
	    $dataSync->accept($table, $op, $data);
	    return response(['affected' => $affected], 200);
    }

	/**
	 * 获取经销商代垫返还数据
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getCustomerDDReturn(Request $request){

    	$custId = $request->input('custId',0);
    	$begin_year = $request->input('begin_year', date('Y'));
    	$begin_month = $request->input('begin_month', date('n')-1);

		$end_year = $request->input('end_year', date('Y'));
		$end_month = $request->input('end_month', date('n')-1);

		$data = [];
		if( $custId > 0 && $begin_year > 0 && $begin_month > 0){
			$data = Utility::getCustomerDDReturn($custId, $begin_year, $begin_month, $end_year, $end_month);
		}
		$user = Auth::user();
		if($user->isAdmin){
			$customers = Customer::where('fdocument_status', 'C')->where('fforbid_status', 'A')->get();
		}else if ($user->reference_type == 'employee'){
			$customers = $user->reference->getVisibleCustomer();
		}
		//
    	return view('admin.utl.ddreturn', compact('custId', 'begin_year', 'begin_month', 'end_year', 'end_month', 'data', 'customers'));
	}

}
