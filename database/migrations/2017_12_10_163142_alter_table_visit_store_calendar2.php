<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVisitStoreCalendar2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('visit_store_calendar', function (Blueprint $table) {
            $table->timestamp('frevisit_date')->nullable()->comment('复巡日期');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('visit_store_calendar', function (Blueprint $table) {
            $table->dropColumn('frevisit_date');
        });
    }
}
