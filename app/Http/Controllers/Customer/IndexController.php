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
//		$year = $request->input('year', date('Y'));
//		$month = $request->input('month', date('n')-1);

		$begin_year = $request->input('begin_year', date('Y'));
		$begin_month = $request->input('begin_month', date('n')-1);

		$end_year = $request->input('end_year', date('Y'));
		$end_month = $request->input('end_month', date('n')-1);


		$data = [];
		if( $custId > 0 && $begin_year > 0 && $begin_month > 0){
			$data = Utility::getCustomerDDReturn($custId, $begin_year, $begin_month, $end_year, $end_month);
		}
		return view('customer.index.ddreturn', compact( 'begin_year', 'begin_month', 'end_year', 'end_month', 'data'));
	}
}
