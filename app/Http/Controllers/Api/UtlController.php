<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Response;
use Image;

class UtlController extends Controller
{
    //
    public function uploadImage(Request $request){
        $file = $request->file('imageFile');
        if($file->isValid())
            $re = $file->store('upload/images');
        return response($re, 200);
    }

    public function showImage(Request $request){
        $imageName = $request->input('imageName');
        $imageName = '1bea3a3faa3838407eec786975f68335.jpeg';
        $image = storage_path('app/upload/images/'. $imageName); //Storage::url('upload/images/' . $imageName);

        $img = Image::make($image)->resize(300, 200);
        return $img->response('jpg');
    }
}
