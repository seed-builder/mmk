<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateViewAttendaceStatistic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    DB::statement("
        create view view_attendace_statistic as 
		SELECT
			femp_id,
			DATE_FORMAT(ftime, '%Y-%m-%d') AS fday,
			CASE ftype
		WHEN 0 THEN
			1
		ELSE
			0
		END 'begin',
		 CASE ftype
		WHEN 1 THEN
			1
		ELSE
			0
		END 'complete'
		FROM
			ms_attendances att
		where EXISTS (select c.id from eng_work_calendar_data c where DATE_FORMAT(att.ftime, '%Y-%m-%d')=DATE_FORMAT(c.fday, '%Y-%m-%d') )
		GROUP BY
			femp_id,
			DATE_FORMAT(ftime, '%Y-%m-%d'),
			ftype;
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	    DB::statement('DROP VIEW IF EXISTS view_attendace_statistic');
    }
}
