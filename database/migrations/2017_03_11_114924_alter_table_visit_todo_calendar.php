<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVisitTodoCalendar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visit_todo_calendar', function (Blueprint $table) {
            //
	        $table->integer('fis_must_visit')->default(1)->comment('是否必须执行');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visit_todo_calendar', function (Blueprint $table) {
            //
	        $table->dropColumn('fis_must_visit');
        });
    }
}
