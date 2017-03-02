<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\ChannelGroup;

class ChannelGroupController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new ChannelGroup($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.channel-group.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.channel-group.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = ChannelGroup::find($id);
		return view('admin.channel-group.edit', ['entity' => $entity]);
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
		$searchCols = ["fdocument_status","fname","fnumber","ftype","fparent_id","id"];

        $data = $request->all();
        $query = ChannelGroup::query();
        foreach ($data['columns'] as $d) {
            if ($d['data']=='id'&&!empty($d['search']['value'])){
                $cg = ChannelGroup::find($d['search']['value']);
                $request['queryBuilder'] = $cg->queryChildren($query,$cg);
            }
        }
		return parent::pagination($request, $searchCols);
	}
	
	public function ajaxGetChannelGroups(){
		$groups = ChannelGroup::query()->where('fparent_id',0)->get();
		$gp_datas = $this->toTextArray($groups);
		
		return $gp_datas;
	}
	
	protected function toTextArray($datas, $selectable = true){
		$rs = [];
		foreach ($datas as $d){
			if($d->getChildrenCountAttribute()>0){
				$rs[]=array(
						'text' => $d->fname,
						'dataid' => $d->id,
						'selectable' => $selectable,
						'nodes' => $this->toTextArray($d->childrenGroup())
				);
			}else{
				$rs[]=array(
						'text' => $d->fname,
						'dataid' => $d->id,
						'selectable' => $selectable
				);
			}
		}
	
		return $rs;
	}

}
