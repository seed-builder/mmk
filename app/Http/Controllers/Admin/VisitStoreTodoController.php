<?php
namespace App\Http\Controllers\Admin;

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
        $todos = VisitStoreTodo::query()->where('fparent_id', 0)->get()->map(function ($item) {
            return ['label' => $item->fname, 'value' => $item->id];
        });
        $todos = $todos->merge([['label' => '无', 'value' => 0]]);
        $functions = VisitFunction::all()->map(function ($item) {
            return ['label' => $item->fname, 'value' => $item->id];
        });
        return view('admin.visit-store-todo.index', compact('todos', 'functions'));
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

}
