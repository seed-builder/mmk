<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\AppUpgrade;

class AppUpgradeController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new AppUpgrade($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.app-upgrade.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.app-upgrade.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = AppUpgrade::find($id);
		return view('admin.app-upgrade.edit', ['entity' => $entity]);
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function show($id)
	{
		//
	}

	/**
	* @param  Request $request
	* @param  array $searchCols
	* @return  \Illuminate\Http\JsonResponse
	*/
	public function pagination(Request $request, $searchCols = [], $with = []){
		$searchCols = ["content","upgrade_date","url","version_code","version_name"];
		return parent::pagination($request, $searchCols);
	}

	public function upload(Request $request){
        $data = $request->all();
        $file = $request->file('appfile');

        if($file->isValid())
        {
            $path = $file->store('upload/apk');

            if($path){
                $res = AppUpgrade::create([
                    'version_code' => date('Ymd'),
                    'version_name' => $data['version_name'],
                    'url' => 'app/' . $path ,
                    'content' => $data['content'],
                    'upgrade_date' => date('Y-m-d H:i:s')
                ]);
            }

            return response()->json([
                'code' => 200,
                'result' => '上传成功！'
            ]);
        }else {
            return response()->json([
                'code' => 200,
                'result' => '上传失败！'
            ]);
        }


    }

}
