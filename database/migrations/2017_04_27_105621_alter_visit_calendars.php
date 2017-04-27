<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVisitCalendars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('visit_line_calendar', function (Blueprint $table) {
		    //
		    $table->timestamp('fbegin')->nullable()->comment('开始时间');
		    $table->timestamp('fend')->nullable()->comment('结束时间');
	    });
	    Schema::table('visit_store_calendar', function (Blueprint $table) {
		    //
		    $table->timestamp('fbegin')->nullable()->comment('开始时间');
		    $table->timestamp('fend')->nullable()->comment('结束时间');
	    });
	    Schema::table('visit_todo_calendar', function (Blueprint $table) {
		    //
		    $table->timestamp('fbegin')->nullable()->comment('开始时间');
		    $table->timestamp('fend')->nullable()->comment('结束时间');
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
	    Schema::table('visit_line_calendar', function (Blueprint $table) {
		    //
		    $table->dropColumn('fbegin');
		    $table->dropColumn('fend');
	    });
	    Schema::table('visit_store_calendar', function (Blueprint $table) {
		    //
		    $table->dropColumn('fbegin');
		    $table->dropColumn('fend');
	    });
	    Schema::table('visit_todo_calendar', function (Blueprint $table) {
		    //
		    $table->dropColumn('fbegin');
		    $table->dropColumn('fend');
	    });
    }
}
