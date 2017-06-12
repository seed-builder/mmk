<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewVisitMonthStoreList extends Migration
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
CREATE or REPLACE view view_visit_month_store_done_list as
SELECT
	DISTINCT
	fstore_id,
	femp_id,
	DATE_FORMAT(fdate, '%Y-%m') fmonth
FROM
	visit_store_calendar
where 
	fstatus=3
GROUP BY
	femp_id,
	DATE_FORMAT(fdate, '%Y-%m') ;
EOD;
	    $query[] = <<<EOD
CREATE or REPLACE view view_visit_month_store_list as
SELECT
	DISTINCT
	fstore_id,
	femp_id,
	DATE_FORMAT(fdate, '%Y-%m') fmonth
FROM
	visit_store_calendar
GROUP BY
	femp_id,
	DATE_FORMAT(fdate, '%Y-%m') 
EOD;
	    $query[] = <<<EOD
#月应拜访门店数
CREATE
OR REPLACE VIEW view_visit_month_store AS 
SELECT
	count(fstore_id) as month_store_total,
	femp_id,
	fmonth
FROM
	 view_visit_month_store_list
GROUP BY
	femp_id,
	fmonth;
EOD;
	    $query[] = <<<EOD
#月已拜访的门店数
CREATE
OR REPLACE VIEW view_visit_month_store_done AS 
SELECT
	count(fstore_id) as month_store_total,
	femp_id,
	fmonth
FROM
	 view_visit_month_store_done_list
GROUP BY
	femp_id,
	fmonth;
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
