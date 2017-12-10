<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewRevisit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $q = <<<EOD
create or replace view view_revisit AS
SELECT
    DISTINCT
	a.*,
	t.femp_id as senior_id,
	d.fname as senior_name,
	e.fnumber as store_number,
	e.ffullname as store_name
FROM
	visit_store_calendar a
INNER JOIN st_stores e ON a.fstore_id = e.id
LEFT JOIN visit_todo_calendar t on t.fstore_calendar_id=a.id and t.fcategory=2
LEFT JOIN bd_employees d on t.femp_id = d.id
WHERE
	a.frevisit_status = 3
ORDER BY
	a.id DESC	
EOD;

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
