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
	    DB::statement("
		create view view_employee_work_calendar as 
		SELECT
			date_format(`c`.`fday`, '%Y-%m-%d') AS `fday`,
			`e`.`id` AS `femp_id`
		FROM
			(
				`eng_work_calendar_data` `c`
				JOIN `bd_employees` `e`
			)
		WHERE
			(
				(`c`.`fis_work_time` = 1)
				AND (
					date_format(`c`.`fday`, '%Y-%m') = date_format(now(), '%Y-%m')
				)
			)
	    ");
        //
	    DB::statement("
		create view view_attendace_preview as 
        SELECT
			`c`.`fday` AS `fday`,
			`c`.`femp_id` AS `femp_id`,
			(
				CASE `m`.`ftype`
				WHEN 0 THEN
					1
				ELSE
					0
				END
			) AS `begin`,
			(
				CASE `m`.`ftype`
				WHEN 1 THEN
					1
				ELSE
					0
				END
			) AS `complete`
		FROM
			(
				`view_employee_work_calendar` `c`
				LEFT JOIN `ms_attendances` `m` ON (
					(
						(
							`c`.`femp_id` = `m`.`femp_id`
						)
						AND (
							`c`.`fday` = date_format(`m`.`ftime`, '%Y-%m-%d')
						)
					)
				)
			)
		GROUP BY
			`c`.`femp_id`,
			`c`.`fday`,
			`m`.`ftype`
    ");

	    DB::statement("
	    CREATE view view_attendace_statistic as 
		select femp_id, fday, SUM(`begin`) as `begin`, SUM(complete) as complete
		from view_attendace_preview
		group by femp_id, fday;
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
	    DB::statement('DROP VIEW IF EXISTS view_employee_work_calendar');
	    DB::statement('DROP VIEW IF EXISTS view_attendace_preview');
	    DB::statement('DROP VIEW IF EXISTS view_attendace_statistic');
    }
}
