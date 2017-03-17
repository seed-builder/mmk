<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTodoCalendar extends Migration
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
	        $table->string('flongitude')->nullable()->comment('百度地图经度');
	        $table->string('flatitude')->nullable()->comment('百度地图纬度');
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
	        $table->dropColumn('flongitude');
	        $table->dropColumn('flatitude');
        });
    }
}
