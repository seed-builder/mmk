<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Customer;
use App\Models\Busi\Store;
use App\Models\Busi\VisitFunction;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\VisitStoreTodo;

class VisitStoreTodoController extends AdminController
{
    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new VisitStoreTodo($attributes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {

        $functions = VisitFunction::all();
        $todos = VisitStoreTodo::all();

        return view('admin.visit-store-todo.index', compact('functions','todos'));
    }


    public function save(Request $request){
        $data = $request->except('_token');
        if (!empty($data['id'])) {
            $todo = $this->newEntity()->newQuery()->find($data['id']);
            $todo->fill($data);
            $todo->flag = $this->todoFlag('.' . $data['id'], $todo);
            if($data['ffunction_id'])
            {
            	$todo->ffunction_number = VisitFunction::find($data['ffunction_id'])->fnumber;
            }else{
	            $todo->ffunction_number ='';
            }

            $todo->save();
        } else {
            $todo = $this->newEntity($data);
	        if($data['ffunction_id'])
	        {
		        $todo->ffunction_number = VisitFunction::find($data['ffunction_id'])->fnumber;
	        }
	        else{
		        $todo->ffunction_number ='';
	        }
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
        VisitStoreTodo::query()->where('fparent_id',$id)->delete();
        VisitStoreTodo::query()->where('id',$id)->delete();
        return response()->json([
            'code' => 200,
            'result' => '删除成功！'
        ]);
    }

    public function todoTree(Request $request)
    {
        $all = VisitStoreTodo::where('fparent_id', 0)->get();
        $tree = [];
        foreach ($all as $top)
            $tree[] = $this->toBootstrapTreeViewData($top, ['text' => 'fname', 'dataid' => 'id'], false);
//        $tree['state'] = ['expanded' => true];
        return response()->json($tree);
    }

}

