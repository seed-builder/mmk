<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVisitStoreCalendar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visit_store_calendar', function (Blueprint $table) {
            //
	        $table->integer('frevisit_status')->default(1)->comment('复巡状态（1-未开始， 2-进行中， 3-已完成）');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visit_store_calendar', function (Blueprint $table) {
            //
	        $table->dropColumn('frevisit_status');
        });
    }
}
