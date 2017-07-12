<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewKpiStockOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    $query[] = <<<EOD
CREATE or REPLACE view view_kpi_stock_out_items as
SELECT
	DATE_FORMAT(i.fmodify_date, '%Y-%m') AS fmonth,
	DATE_FORMAT(i.fmodify_date, '%Y-%m-%d') AS fdate,
	i.famount,
	c.fseller AS femp_id
FROM
	st_stock_out_items i
INNER JOIN st_stock_outs o ON i.fstock_out_id = o.id
LEFT JOIN bd_customers c ON o.fcust_id = c.id
WHERE
	i.fdocument_status = 'C';
	
EOD;

	    $query[] = <<<EOD
CREATE or REPLACE view view_kpi_stock_out_day as
SELECT
	fdate,
	femp_id,
	sum(famount) as famount
FROM
	view_kpi_stock_out_items i
group by fdate, femp_id;
	
EOD;

	    $query[] = <<<EOD
CREATE or REPLACE view view_kpi_stock_out_month as
SELECT
	fmonth,
	femp_id,
	sum(famount) as famount
FROM
	view_kpi_stock_out_items i
group by fmonth, femp_id;
	
EOD;

	    $query[] = <<<EOD
CREATE OR REPLACE VIEW view_visit_kpi AS  
SELECT
	ed.fdate,
	ed.femp_id,
	emp.fname,
	pos.fname AS position_name,
	st.store_total,
	vst.valid_store_total,
	ds.day_store_total,
	dsd.day_store_done_total,
	ms.month_store_total,
	msd.month_store_total as month_store_done_total,
	msd.month_store_total / vst.valid_store_total * 100 AS rate,
	dcs.store_cost_second_total AS day_cost_total,
	mcs.store_cost_second_total AS month_cost_total,
	round(
		mcs.store_cost_second_total / msd.month_store_total
	) AS store_avg_cost,
	mst.times as month_times_total,
	msdt.times as month_done_times_total,
	msdt.times / mst.times * 100 as month_times_rate,
	sod.famount as day_amount,
	som.famount as month_amount,
	round( som.famount / msd.month_store_total ) as num_amount,
	round( som.famount / msdt.times ) as times_amount
FROM
	view_visit_employee_day ed
INNER JOIN bd_employees emp ON ed.femp_id = emp.id
LEFT JOIN bd_positions pos ON emp.fpost_id = pos.id

LEFT JOIN view_visit_store st ON ed.femp_id = st.femp_id
LEFT JOIN view_visit_valid_store vst ON ed.femp_id = vst.femp_id
LEFT JOIN view_visit_day_store ds on ed.femp_id = ds.femp_id and ds.fdate=ed.fdate
LEFT JOIN view_visit_day_store_done dsd on ed.femp_id=dsd.femp_id and dsd.fdate=ed.fdate
LEFT JOIN view_visit_month_store ms ON ed.femp_id = ms.femp_id AND ed.fmonth = ms.fmonth
LEFT JOIN view_visit_month_store_done msd ON ed.femp_id = msd.femp_id AND ed.fmonth = msd.fmonth
LEFT JOIN view_visit_day_cost_sum dcs on ed.femp_id=dcs.femp_id and dcs.fdate=ed.fdate
LEFT JOIN view_visit_month_cost_sum mcs ON ed.femp_id = mcs.femp_id AND ed.fmonth = mcs.fmonth
LEFT JOIN  view_visit_month_store_times mst on ed.femp_id=mst.femp_id AND ed.fmonth = mst.fmonth
LEFT JOIN  view_visit_month_store_done_times msdt on ed.femp_id=msdt.femp_id AND ed.fmonth = msdt.fmonth
LEFT JOIN view_kpi_stock_out_day sod on ed.femp_id=sod.femp_id and ed.fdate=sod.fdate
LEFT JOIN view_kpi_stock_out_month som on ed.femp_id=som.femp_id and ed.fmonth=som.fmonth
;
EOD;

	    foreach ($query as $q)
		    DB::statement($q);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
