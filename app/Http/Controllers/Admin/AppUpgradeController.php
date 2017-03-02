<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Resources;
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
	 * @param array $with
	 * @param null $conditionCall
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null){
		$searchCols = ["content","upgrade_date","url","version_code","version_name"];
		return parent::pagination($request, $searchCols);
	}

	public function upload(Request $request){
        $data = $request->all();
        $file = $request->file('appfile');

        if($file->isValid())
        {
	        $name = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('upload/apk', $name);

	        if($path){
		        $res = Resources::create([
			        'name' => $file->getClientOriginalName(),
			        'ext' => $file->getClientOriginalExtension(),
			        'size' => $file->getSize(),
			        'path' => 'app/' . $path ,
			        'mimetype' => $file->getMimeType(),
		        ]);
		        $sign = api_sign(['id' => $res->id]);
		        $app = AppUpgrade::create([
			        'version_code' => $data['version_code'],
			        'version_name' => $data['version_name'],
                    'enforce' => $data['enforce'],
			        'url' => url('/api/utl/download-file?id=' . $res->id . '&_sign=' . $sign),
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
                'code' => 500,
                'result' => '上传失败！'
            ]);
        }


    }

}
