<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Response;
use Image;
use App\Models\ModelMap;
use App\Models\Busi\Resources;
use Log;

class UtlController extends ApiController
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
        $imageName = $request->input('imageName');
        $imageName = '1bea3a3faa3838407eec786975f68335.jpeg';
        $image = storage_path('app/upload/images/'. $imageName); //Storage::url('upload/images/' . $imageName);

        $img = Image::make($image)->resize(300, 200);
        return $img->response('jpg');
    }

    /**
     * 数据库同步
     * @param Request $request
     * @return Response
     */
    public function syncDB(Request $request){
        $map =  new ModelMap; //::find(11);
        $map->model='xxx';
        $map->table = 'yyyy';
        $re = $map->save();

        Log::info('model created: '. json_encode($map));
        return response('success', 200);
    }

}
