<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\ViewVisitKpi;

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
            $ids = $this->getCurUsersEmployeeIds();
            if (!empty($ids)) {
                $query->whereIn('femp_id', $ids);
            }
        });
    }

	public function export($datas)
	{
		$data = [['门店编码', '门店全称', '详细地址', '负责人', '联系电话', '负责业代', '经销商', '路线','渠道','是否签约','审核状态']];
		foreach ($datas as $d) {
			$status = "无";
			switch ($d->fdocument_status){
				case 'A':
					$status= '未审核';
					break;
				case 'C':
					$status= '已审核';
					break;
				case 'B':
					$status= '审核中';
					break;

			}
			$signed = $d->fis_signed ? '是':'否';

			$data[] = [
				$d->fnumber,
				$d->ffullname,
				$d->faddress,
				$d->fcontracts,
				$d->ftelephone,
				$d->employee ? $d->employee->fname : '',
				$d->customer ? $d->customer->fname : '',
				$d->line ? $d->line->fname : '',
				$d->channel ? $d->channel->fname : '',
				$signed,
				$status
			];
		}

		$excel = new ExcelService();
		$excel->export($data, date('Ymd') . '_门店信息');
	}

}
