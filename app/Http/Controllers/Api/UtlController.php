<?php

namespace App\Http\Controllers\Api;

use App\Services\DataSync\KingdeeWorker;
use App\Services\MessageService;
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
use Sms;

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
	    if(!empty($image)) {
		    $image = storage_path($image->path);
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
			$path = $file->store('upload/files');
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
	    $dataSync = app('dataSync');
	    $affected = $dataSync->accept($table, $op, $data?$data:[]);
	    //var_dump($affected);
	    return response(['affected' => $affected], 200);
    }

	/**
	 * 发送验证码短信
	 * @param Request $request
	 * @return Response
	 */
    public function sendVerifyCode(Request $request){
    	$phone = $request->input('phone');
	    $resp = Sms::verify($phone);
	    ///var_dump($resp);
	    $status = !empty($resp->result) && $resp->result->success ? 200 : 400;
	    return response(['result' => $resp], $status);
    }

	/**
	 * 判断验证码是否正确
	 * @param Request $request
	 * @return Response
	 */
    public function checkVerifyCode(Request $request){
	    $phone = $request->input('phone');
	    $code = $request->input('code');
	    $resp = Sms::checkVerifyCode($phone, $code);
	    $status = $resp ? 200 : 400;
	    return response(['success' => $resp], $status);
    }

	/**
	 * 获取经销商账款余额接口
	 */
    public function getCustAmount(Request $request, $cust_id){
    	if(env('APP_DEBUG')){
		    return response(['data' => 100.10, 'code' => 200, 'msg' => '', 'success' => true]);
	    }
//	    $worker = new KingdeeWorker();
//	    $url = env('KINGDEE_HOST') . '/k3cloud/CYD.ApiService.ServicesStub.CustomBusinessService.CustBalAmountGet.common.kdsvc';
//	    $res = $worker->post($url, ['parameters' => [$cust_id]]);
	    $amount = Utility::getCustomerBalance($cust_id);
	    return response(['data' => $amount, 'code' => 200, 'msg' => '', 'success' => true]);
    }

    public function pushMessage(Request $request, $user_id){
    	$msg = $request->input('msg');
    	$title = $request->input('title');
    	$type = $request->input('type');
    	$res = MessageService::Instance()->pushToApp([$user_id], $type, $title, $msg);
		return response(['data' => $res, 'code' => 200, 'msg' => '', 'success' => true]);
    }

}
