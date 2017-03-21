<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Store;
use App\Models\Busi\VisitFunction;
use App\Models\Busi\VisitTodoTemp;
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
//        $todos = VisitStoreTodo::query()->where('fparent_id', 0)->get()->map(function ($item) {
//            return ['label' => $item->fname, 'value' => $item->id];
//        });
//        $todos = $todos->merge([['label' => '无', 'value' => 0]]);
//        $functions = VisitFunction::all()->map(function ($item) {
//            return ['label' => $item->fname, 'value' => $item->id];
//        });

        $todos = VisitStoreTodo::all();

        $ids = $this->getCurUsersEmployeeIds();
        $stores= [] ;
        if (!empty($ids)) {
            $stores = Store::query()->whereIn('femp_id', $ids)->get();
        }

        $functions = VisitFunction::all();

        return view('admin.visit-store-todo.index', compact('todos', 'functions','stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.visit-store-todo.create');
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = VisitStoreTodo::find($id);
        return view('admin.visit-store-todo.edit', ['entity' => $entity]);
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
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
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
    {
        $searchCols = ["fchildren_calculate", "fdocument_status", "ffunction_number", "fgroup_id", "flag", "fname", "fnumber"];
        $with = ['parent', 'ffunction'];
        return parent::pagination($request, $searchCols, $with);
    }

    public function store(Request $request, $extraFields = [])
    {

        $data = $request->input('data', []);
		if(empty($data))
            return $this->fail('data is empty');
		$props = current($data);
		$fieldErrors = $this->validateFields($props);
		if(!empty($fieldErrors)){
            return $this->fail('validate error', $fieldErrors);
        } else {
            $entity = $this->newEntity($props);
            $entity->ffunction_number = VisitFunction::find($props['ffunction_id'])->fnumber;

            $entity->save();

            $entity->flag = '.'.$entity->id;
            if ($props['fparent_id']!=0)
                $entity->flag = '.'.$props['fparent_id'].'.'.$entity->id;

            $entity->save();
            return $this->success($entity);
        }
    }

    public function update(Request $request, $id, $extraFields = [])
    {
        $data = $request->input('data', []);
        if (empty($data))
            return $this->fail('data is empty');

        //$props = current($data);
        $props = $this->beforeSave(current($data));
        $fieldErrors = $this->validateFields($props);
        if (!empty($fieldErrors)) {
            return $this->fail('validate error', $fieldErrors);
        } else {
            $entity = $this->newEntity()->newQuery()->find($id);
            $entity->fill($props);
            $entity->ffunction_number = VisitFunction::find($props['ffunction_id'])->fnumber;
            $entity->flag = '.'.$entity->id;
            if ($props['fparent_id']!=0)
                $entity->flag = '.'.$props['fparent_id'].'.'.$entity->id;

            $entity->save();
            return $this->success($entity);
        }
    }

    public function save(Request $request){
        $data = $request->except('_token');
        if ($data['use_template']==2){
            $tems = VisitTodoTemp::query()->where('fparent_id',0)->get();
            foreach ($tems as $t){
                $todo = $this->newEntity($t->toArray());
                $todo->fstore_id = $data['fstore_id'];
                $todo->save();
                $todo->flag = ".".$todo->id;
                $todo->save();
                if (!empty($t->children)){
                    foreach ($t->children as $child){
                        $todo_child = $this->newEntity($child->toArray());
                        $todo_child->fstore_id = $data['fstore_id'];
                        $todo_child->fparent_id = $todo->id;
                        $todo_child->save();
                        $todo_child->flag = $this->todoFlag(".".$todo_child->id,$todo_child); ;
                        $todo_child->save();
                    }
                }
            }

            return response()->json([
                'code' => 200,
                'result' => '根据模板生成成功！'
            ]);
        }

        unset($data['use_template']);

        if (!empty($data['id'])){
            $todo = $this->newEntity()->newQuery()->find($data['id']);
            $todo->fill($data);
            $todo->flag = $this->todoFlag('.'.$data['id'],$todo);
            $todo->ffunction_number = VisitFunction::find($data['ffunction_id'])->fnumber;

            $todo->save();
        }else{
            $todo = $this->newEntity($data);
            $todo->ffunction_number = VisitFunction::find($data['ffunction_id'])->fnumber;

            $todo->save();
            $todo->flag = $this->todoFlag('.'.$todo->id,$todo);
            $todo->save();
        }

        return response()->json([
            'code' => 200,
            'result' => '保存成功！'
        ]);
    }

    public function todoFlag($flag,$todo){
        if (!empty($todo->parent)){
            $flag='.'.$todo->parent->id.$flag;

            $this->todoFlag($flag,$todo->parent);
        }
        return $flag;
    }


    public function todoTree(Request $request)
    {
        $fstore_id = $request->input('fstore_id',0);
        $all = VisitStoreTodo::where('fparent_id', 0)->where('fstore_id',$fstore_id)->get();
        $tree = [];
        foreach ($all as $top)
         $tree[] = $this->toBootstrapTreeViewData($top, ['text' => 'fname', 'dataid' => 'id'], false);
//        $tree['state'] = ['expanded' => true];
        return response()->json($tree);
    }

    public function storeTodoList($id){
        return response()->json([
            'code' => 200,
            'data' => VisitStoreTodo::query()->where('fstore_id',$id)->get()
        ]);
    }

    public function todosTemplate(){
        $all = VisitTodoTemp::where('fparent_id', 0)->get();
        $tree = [];
        foreach ($all as $top)
            $tree[] = $this->toBootstrapTreeViewData($top, ['text' => 'fname', 'dataid' => 'id'], false);
//        $tree['state'] = ['expanded' => true];
        return response()->json($tree);
    }

    public function delete($id){
        VisitStoreTodo::query()->where('id',$id)->delete();
        VisitStoreTodo::query()->where('fparent_id',$id)->delete();

        return response()->json([
            'code' => 200,
            'result' => '删除成功！'
        ]);
    }
}
