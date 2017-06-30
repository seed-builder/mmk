<?php

namespace App\Http\Controllers\Customer;

use App\Models\Busi\Resources;
use App\Services\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Image;

class IndexController extends BaseController
{
	//
	public function index(){
		return view('customer.index.index');
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

	/**
	 * 获取经销商代垫返还数据
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getCustomerDDReturn(Request $request){

//		$custId = $request->input('custId',0);
		$custId = Auth::user()->reference_id;
		$year = $request->input('year', date('Y'));
		$month = $request->input('month', date('n')-1);
		$data = [];
		if( $custId > 0 && $year > 0 && $month > 0){
			$data = Utility::getCustomerDDReturn($custId, $year, $month);
		}
		return view('customer.index.ddreturn', compact( 'year', 'month', 'data'));
	}
}
