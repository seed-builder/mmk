<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Customer;
use App\Models\Busi\Store;
use App\Models\Busi\VisitStoreTodo;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\VisitTodoGroup;

class VisitTodoGroupController extends AdminController
{
    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new VisitTodoGroup($attributes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return view('admin.visit-todo-group.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.visit-todo-group.create');
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = VisitTodoGroup::find($id);
        return view('admin.visit-todo-group.edit', ['entity' => $entity]);
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
     * @param  bool $all_columns
     * @return  \Illuminate\Http\JsonResponse
     */
    public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
    {
        $searchCols = ["fdocument_status", "fname", "fremark"];
        return parent::pagination($request, $searchCols);
    }

    public function todoGroupTree(Request $request)
    {

        $todoGroup = VisitTodoGroup::find($request->input('id'));
        if (empty($todoGroup))
            return response()->json([]);
        $all = $todoGroup->todos->where('fparent_id', 0);
        $tree = [];
        foreach ($all as $top)
            $tree[] = $this->toBootstrapTreeViewData1($top, ['text' => 'fname', 'dataid' => 'id'], false, $todoGroup->todos->pluck('id')->toArray());
//        $tree['state'] = ['expanded' => true];
        return response()->json($tree);
    }

    public function toBootstrapTreeViewData1($entity, $props, $expanded = true, $todoids)
    {
        $data = ['item' => $entity];
        if (!empty($entity)) {
            foreach ($props as $k => $val) {

                $data[$k] = $entity->{$val};
                $data['state']['expanded'] = $expanded;

            }

            if (!empty($entity->children)) {
                $nodes = [];
                foreach ($entity->children as $child) {
                    if (in_array($child->id,$todoids)) {
                        $nodes[] = $this->toBootstrapTreeViewData($child, $props, $expanded);
                    }
                }
                if (!empty($nodes))
                    $data['nodes'] = $nodes;

            }
        }
        return $data;
    }

    public function config()
    {
        $customers = Customer::all();
        $groups = VisitTodoGroup::all()->where('fdate','>',date("Y-m-d"));
        return view('admin.visit-todo-group.config', compact('customers', 'groups'));
    }

    public function addTodo(Request $request){
        $data = $request->all();
        $ids = [];
        $todo = VisitStoreTodo::find($data['todo_id']);
        $vp = VisitTodoGroup::find($data['group_id']);

        $ids[] = $todo->id;
        if (!empty($todo->children)){
            foreach ($todo->children as $t)
                $ids[]=$t->id;
        }

        $ids = array_diff($ids,$vp->todos->pluck('id')->toArray());

        $vp->todos()->attach($ids);

        return response()->json([
            'code' => 200,
            'result' => '添加成功！'
        ]);
    }

    public function removeTodo(Request $request){
        $data = $request->all();

        $ids = [];
        $todo = VisitStoreTodo::find($data['todo_id']);
        $ids[] = $todo->id;
        if (!empty($todo->children)){
            foreach ($todo->children as $t)
                $ids[]=$t->id;
        }

        $vp = VisitTodoGroup::find($data['group_id']);

        $vp->todos()->detach($ids);
        return response()->json([
            'code' => 200,
            'result' => '删除成功！'
        ]);
    }

    public function makeTodoByGroup(Request $request){
        $data = $request->all();

        $store_ids = explode(',',$data['todo_ids']);
        $vp = VisitTodoGroup::find($data['group_id']);

        $store_ids = array_diff($store_ids,$vp->stores->pluck('id')->toArray());
        $vp->stores()->attach($store_ids);

        return response()->json([
            'code' => 200,
            'result' => '生成成功！'
        ]);
    }

}
