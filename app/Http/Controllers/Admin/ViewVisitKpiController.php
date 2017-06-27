<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\ViewVisitKpi;
use Illuminate\Support\Facades\Auth;

class ViewVisitKpiController extends AdminController
{
    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new ViewVisitKpi($attributes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.view-visit-kpi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.view-visit-kpi.create');
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = ViewVisitKpi::find($id);
        return view('admin.view-visit-kpi.edit', ['entity' => $entity]);
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
        $searchCols = ["fname", "position_name"];

        return parent::pagination($request, $searchCols, $with, function ($query) use ($request) {
            $filters = $request->input('filter', []);
            $date = date('Y-m-d');
            foreach ($filters as $filter) {
                if ($filter['name'] == 'fdate' && !empty($filter['value']))
                    $date = $filter['value'];
            }
            $query->where('fdate', '=', $date);
	        $user = Auth::user();
	        if(!$user->isAdmin()) {
		        $ids = $this->getCurUsersEmployeeIds();
		        if (!empty($ids)) {
			        $query->whereIn('femp_id', $ids);
		        }
	        }
        });
    }
}
