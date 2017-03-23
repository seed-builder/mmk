<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\VisitFunction;
use App\Models\Busi\VisitStoreTodo;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\VisitTodoTemp;

class VisitTodoTempController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new VisitTodoTemp($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/

	public function index()
	{
        $functions = VisitFunction::all();
		return view('admin.visit-todo-temp.index',compact('functions'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.visit-todo-temp.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = VisitTodoTemp::find($id);
		return view('admin.visit-todo-temp.edit', ['entity' => $entity]);
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
	* @param  array $with
	* @param  null $conditionCall
	* @param  bool $all_columns
	* @return  \Illuminate\Http\JsonResponse
	*/
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$searchCols = ["fchildren_calculate","fdocument_status","ffunction_number","fgroup_id","flag","fname","fnumber"];
		return parent::pagination($request, $searchCols);
	}

    public function tempTree()
    {
        $all = VisitTodoTemp::where('fparent_id', 0)->get();
        $tree = [];
        foreach ($all as $top)
            $tree[] = $this->toBootstrapTreeViewData($top, ['text' => 'fname', 'dataid' => 'id'], false);
//        $tree['state'] = ['expanded' => true];
        return response()->json($tree);
    }

    public function save(Request $request){
        $data = $request->except('_token');
        if (!empty($data['id'])) {
            $todo = $this->newEntity()->newQuery()->find($data['id']);
            $todo->fill($data);
            $todo->flag = $this->todoFlag('.' . $data['id'], $todo);
            $todo->ffunction_number = VisitFunction::find($data['ffunction_id'])->fnumber;

            $todo->save();
        } else {
            $todo = $this->newEntity($data);
            $todo->ffunction_number = VisitFunction::find($data['ffunction_id'])->fnumber;

            $todo->save();
            $todo->flag = $this->todoFlag('.' . $todo->id, $todo);
            $todo->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '保存成功！'
        ]);
    }

    public function todoFlag($flag, $todo)
    {
        if (!empty($todo->parent)) {
            $flag = '.' . $todo->parent->id . $flag;

            $this->todoFlag($flag, $todo->parent);
        }
        return $flag;
    }

    public function delete($id){
        VisitTodoTemp::query()->where('fparent_id',$id)->delete();
        VisitTodoTemp::query()->where('id',$id)->delete();
        return response()->json([
            'code' => 200,
            'result' => '删除成功！'
        ]);
    }

}
