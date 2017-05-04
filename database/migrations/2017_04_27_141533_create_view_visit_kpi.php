<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewVisitKpi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    $view_visit_valid_cust = <<<EOD
	    #有效客户数(门店数)
CREATE
OR REPLACE VIEW view_visit_valid_cust AS SELECT
	femp_id,
	COUNT(1) AS cust_total
FROM
	st_stores
GROUP BY
	femp_id;
EOD;

	    $view_visit_line_cust = <<<EOD
#线路客户(门店数)
CREATE
OR REPLACE VIEW view_visit_line_cust AS SELECT DISTINCT
	ls.fstore_id,
	ls.femp_id
FROM
	visit_line_store ls
EOD;

	    $view_visit_line_cust_count = <<<EOD
#线路总客户数(门店数)
CREATE
OR REPLACE VIEW view_visit_line_cust_count AS SELECT
	femp_id,
	COUNT(fstore_id) AS line_cust_total
FROM
	view_visit_line_cust
GROUP BY
	femp_id;
EOD;

	    $view_visit_day_cust = <<<EOD
#日拜访客户
CREATE
OR REPLACE VIEW view_visit_day_cust AS SELECT DISTINCT
	sc.fstore_id,
	sc.femp_id,
	sc.fdate
FROM
	visit_store_calendar sc
WHERE
	sc.fstatus > 1;
EOD;

	    $view_visit_day_cust_count = <<<EOD
#日拜访的客户数
CREATE
OR REPLACE VIEW view_visit_day_cust_count AS SELECT
	fdate,
	femp_id,
	COUNT(fstore_id) AS day_visit_cust_num
FROM
	view_visit_day_cust
GROUP BY
	femp_id,
	fdate;
EOD;

	    $view_visit_month_cust = <<<EOD
#月拜访客户
CREATE
OR REPLACE VIEW view_visit_month_cust AS SELECT DISTINCT
	sc.fstore_id ,
	sc.femp_id,
	DATE_FORMAT(sc.fdate, '%Y-%m') fmonth
FROM
	visit_store_calendar sc
WHERE
	sc.fstatus > 1;
EOD;

	    $view_visit_month_cust_count = <<<EOD
#月拜访的客户数
CREATE
OR REPLACE VIEW view_visit_month_cust_count AS SELECT
	fmonth,
	femp_id,
	COUNT(fstore_id) AS month_visit_cust_num
FROM
	view_visit_month_cust
GROUP BY
	femp_id,
	fmonth;
EOD;

	    $view_visit_day_cost = <<<EOD
CREATE OR REPLACE VIEW view_visit_day_cost AS SELECT
	fdate,
	femp_id,
	fstore_id,
	fbegin,
	fend,
	timestampdiff(SECOND, fbegin, fend) AS store_cost_second
FROM
	visit_store_calendar;
EOD;

		$view_visit_day_cost_sum = <<<EOD
#日门店拜访用时汇总
	CREATE
OR REPLACE VIEW view_visit_day_cost_sum AS SELECT
	fdate,
	femp_id,
	sum(store_cost_second) AS store_cost_second_total
FROM
	view_visit_day_cost
GROUP BY
	fdate,
	femp_id;
EOD;

	    $view_visit_month_cost = <<<EOD
#月门店拜访用时
CREATE
OR REPLACE VIEW view_visit_month_cost AS SELECT
	DATE_FORMAT(fdate, '%Y-%m') fmonth,
	femp_id,
	fstore_id,
	fbegin,
	fend,
	timestampdiff(SECOND, fbegin, fend) AS store_cost_second
FROM
	visit_store_calendar;
EOD;

	    $view_visit_month_cost_sum = <<<EOD
#月门店拜访用时汇总
CREATE
OR REPLACE VIEW view_visit_month_cost_sum AS SELECT
	fmonth,
	femp_id,
	sum(store_cost_second) AS store_cost_second_total
FROM
	view_visit_month_cost
GROUP BY
	fmonth,
	femp_id;
EOD;

	    $view_visit_kpi = <<<EOD
CREATE OR REPLACE VIEW view_visit_kpi AS SELECT
	dcs.fdate,
	dcs.femp_id,
	emp.fname,
	pos.fname AS position_name,
	lcc.line_cust_total,
	vc.cust_total AS valid_cust_total,
	dcc.day_visit_cust_num,
	mcc.month_visit_cust_num,
	mcc.month_visit_cust_num / vc.cust_total * 100 AS rate,
	dcs.store_cost_second_total AS day_cost_total,
	mcs.store_cost_second_total AS month_cost_total,
	round(
		mcs.store_cost_second_total / mcc.month_visit_cust_num
	) AS cust_avg_cost
FROM
	view_visit_day_cost_sum dcs
INNER JOIN bd_employees emp ON dcs.femp_id = emp.id
LEFT JOIN bd_positions pos ON emp.fpost_id = pos.id
LEFT JOIN view_visit_line_cust_count lcc ON dcs.femp_id = lcc.femp_id
LEFT JOIN view_visit_valid_cust vc ON dcs.femp_id = vc.femp_id
LEFT JOIN view_visit_day_cust_count dcc ON dcs.femp_id = dcc.femp_id
AND dcs.fdate = dcc.fdate
LEFT JOIN view_visit_month_cust_count mcc ON dcs.femp_id = mcc.femp_id
AND DATE_FORMAT(dcs.fdate, '%Y-%m') = mcc.fmonth
LEFT JOIN view_visit_month_cost_sum mcs ON dcs.femp_id = mcs.femp_id
AND DATE_FORMAT(dcs.fdate, '%Y-%m') = mcs.fmonth
WHERE
	DATE_FORMAT(dcs.fdate, '%Y-%m-%d') <= DATE_FORMAT(now(), '%Y-%m-%d');
	
EOD;
	    //
	    DB::statement($view_visit_valid_cust);
	    DB::statement($view_visit_line_cust);
	    DB::statement($view_visit_line_cust_count);
	    DB::statement($view_visit_day_cust);
	    DB::statement($view_visit_day_cust_count);
	    DB::statement($view_visit_day_cost);
	    DB::statement($view_visit_day_cost_sum);
	    DB::statement($view_visit_month_cust);
	    DB::statement($view_visit_month_cust_count);
	    DB::statement($view_visit_month_cost);
	    DB::statement($view_visit_month_cost_sum);
	    DB::statement($view_visit_kpi);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	    $drop = <<<EOD
drop VIEW  view_visit_valid_cust;
drop VIEW  view_visit_line_cust;
drop VIEW  view_visit_line_cust_count;
drop VIEW  view_visit_day_cust;
drop VIEW  view_visit_day_cust_count;
drop VIEW  view_visit_month_cust;
drop VIEW  view_visit_month_cust_count;
drop VIEW  view_visit_day_cost;
drop VIEW  view_visit_day_cost_sum;
drop VIEW  view_visit_month_cost;
drop VIEW  view_visit_month_cost_sum;
drop VIEW  view_visit_kpi;
EOD;



    }
}
