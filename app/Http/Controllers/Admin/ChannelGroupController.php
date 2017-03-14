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
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false){
		$searchCols = ["fdocument_status","fname","fnumber","ftype","fparent_id","id"];

        $data = $request->all();

		return parent::pagination($request, $searchCols,$with,function ($queryBuilder) use ($data) {
            if (!empty($data['nodeid'])) {
                $channelGroup = ChannelGroup::find($data['nodeid']);
                $ids = $channelGroup->getChildrenIds($data['nodeid']);
                $queryBuilder->whereIn('id', $ids);
            }
        });
	}

    public function channelGroupTree(){
        $all = ChannelGroup::where('fparent_id', 0)->get();
        foreach ($all as $top){
            $tree[] = $this->toBootstrapTreeViewData($top,  ['text' => 'fname', 'dataid' => 'id'], false);
        }

        return response()->json($tree);
    }
	

}
