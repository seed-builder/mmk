<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\ViewVisitKpi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function pagination_old(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
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
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $columns = $request->input('columns', []);
        $order = $request->input('order', []);
        $search = $request->input('search', []);
        $draw = $request->input('draw', 0);
        $filters = $request->input('filter', []);

        $conditions = [];
        foreach ($columns as $column) {
            if (!$all_columns)
                $fields[] = $column['data'];
            if (!empty($column['search']['value'])) {
                $conditions[$column['data']] = $column['search']['value'];
            }
        }
        $queryBuilder = $this->entityQuery();
        $count = DB::select('select count(1) c from view_visit_employee_day ');//$queryBuilder->count();
        $total = $count[0]->c;

        $date = date('Y-m-d');
        foreach ($filters as $filter) {
            if ($filter['name'] == 'fdate' && !empty($filter['value'])) {
                $date = $filter['value'];
            }
            else{
                $operator = !empty($filter['operator']) ? $filter['operator'] : '=';
                if ($operator == 'like')
                    $queryBuilder->where($filter['name'], $operator, '%' . $filter['value'] . '%');
                else
                    $queryBuilder->where($filter['name'], $operator, $filter['value']);
            }
        }
        $queryBuilder->where('fdate', '=', $date);

        $user = Auth::user();
        if(!$user->isAdmin()) {
            $ids = $this->getCurUsersEmployeeIds();
            if (!empty($ids)) {
                $queryBuilder->whereIn(DB::raw('view_visit_kpi.femp_id'), $ids);
            }
        }

        foreach ($conditions as $col => $val) {
            $queryBuilder->where($col, $val);
        }

        $filterCount = $queryBuilder->count();

        foreach ($order as $o) {
            $index = $o['column'];
            $dir = $o['dir'];
            $queryBuilder->orderBy($columns[$index]['data'], $dir);
        }
        if($length > 0) {
            $queryBuilder->skip($start)->take($length);
        }
        $querySql = $queryBuilder->toSql();
        $idx = strpos($querySql, 'where');
        $rest_sql = substr($querySql, $idx);

        $sql = <<<EOD
select 
view_visit_kpi.*,
st.store_total,
vst.valid_store_total,
view_visit_kpi.month_store_done_total / vst.valid_store_total * 100 AS rate

from view_visit_kpi

LEFT JOIN (SELECT
	`st_stores`.`femp_id` AS `femp_id`,
	count(1) AS `store_total`
FROM
	`st_stores`
WHERE `st_stores`.`fcreate_date` <= '{$date}'
GROUP BY
	`st_stores`.`femp_id`
) st on view_visit_kpi.femp_id = st.femp_id

LEFT JOIN (SELECT
	`st_stores`.`femp_id` AS `femp_id`,
	count(1) AS `valid_store_total`
FROM
	`st_stores`
WHERE
	`st_stores`.`fdocument_status` = 'C' AND 
	`st_stores`.`fforbid_status` = 'A'	AND
	`st_stores`.`fline_id` IS NOT NULL AND
	`st_stores`.`fcreate_date` <= '{$date}'
GROUP BY
	`st_stores`.`femp_id`
) vst on view_visit_kpi.femp_id = vst.femp_id

{$rest_sql}
EOD;

        $entities = DB::select($sql, $queryBuilder->getBindings());
//        $entities = $queryBuilder->skip($start)->take($length)->get();
//	    var_dump($queryBuilder->toSql());
        //LogSvr::sql()->info($queryBuilder->toSql());
        $result = [
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filterCount,
            'data' => $entities
        ];
        return response()->json($result);
    }


}
