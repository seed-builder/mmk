<?php

namespace App\Http\Controllers\Customer;

use App\Models\Busi\Resources;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
