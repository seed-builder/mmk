<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterViewVisitKpi2 extends Migration
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
CREATE or REPLACE view view_visit_month_store_list as
SELECT
	distinct
	`visit_store_calendar`.`fstore_id` AS `fstore_id`,
	`visit_store_calendar`.`femp_id` AS `femp_id`,
	date_format(
		`visit_store_calendar`.`fdate`,
		'%Y-%m'
	) AS `fmonth`
FROM
	`visit_store_calendar`;
	
EOD;

	    $query[] = <<<EOD
CREATE or REPLACE view view_visit_month_store_done_list as
SELECT DISTINCT
	`visit_store_calendar`.`fstore_id` AS `fstore_id`,
	`visit_store_calendar`.`femp_id` AS `femp_id`,
	date_format(
		`visit_store_calendar`.`fdate`,
		'%Y-%m'
	) AS `fmonth`
FROM
	`visit_store_calendar`
WHERE
	(
		`visit_store_calendar`.`fstatus` = 3
	)
	
EOD;

	    $query[] = <<<EOD
create or replace view view_visit_month_store_times_list
as
SELECT
	fstore_id,
	femp_id,
	date_format(
		`visit_store_calendar`.`fdate`,
		'%Y-%m'
	) AS `fmonth`,
	fstatus
FROM
	`visit_store_calendar`;
	
EOD;


	    $query[] = <<<EOD
create or replace view view_visit_month_store_done_times
as
SELECT
	count(1) as times,
	femp_id,
	fmonth
FROM
	view_visit_month_store_times_list
where fstatus=3
GROUP BY
	femp_id,
	fmonth;
	
EOD;

	    $query[] = <<<EOD
create or replace view view_visit_month_store_times
as
SELECT
	count(1) as times,
	femp_id,
	fmonth
FROM
	view_visit_month_store_times_list
GROUP BY
	femp_id,
	fmonth;
	
EOD;

	    $query[] = <<<EOD
CREATE
OR REPLACE VIEW view_visit_kpi AS SELECT
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
	) AS store_avg_cost
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
