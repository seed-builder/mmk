<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\Channel;
use App\Models\Busi\ChannelGroup;

class ChannelController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Channel($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		$all = ChannelGroup::all();
		$groups = $all->map(function ($item){
			return ['label' => $item->fname, 'value' => $item->id];
		});
		$groups[]=['label' => '无', 'value' => 0];
		
		return view('admin.channel.index',compact('groups'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.channel.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = Channel::find($id);
		return view('admin.channel.edit', ['entity' => $entity]);
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
		$searchCols = ["fdocument_status","fname","fnumber","fremark"];
        $data = $request->all();

        $query = Channel::query();

        foreach ($data['columns'] as $d) {
            if ($d['data']=='fgroup_id'&&!empty($d['search']['value'])){
                $entity = new ChannelGroup();
                $ids = $entity->getChildrenIds($d['search']['value']);
                $request['queryBuilder'] = $query->whereIn('fgroup_id',$ids);
            }
        }

		return parent::pagination($request, $searchCols);
	}



}
