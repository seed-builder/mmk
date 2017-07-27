<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVisitStoreTodos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visit_store_todo', function (Blueprint $table) {
            //
	        $table->integer('fcategory')->default(1)->comment('分类(1-正常巡访项, 2-组长复巡项)');
        });

	    Schema::table('visit_todo_calendar', function (Blueprint $table) {
		    //
		    $table->integer('fcategory')->default(1)->comment('分类(1-正常巡访项, 2-组长复巡项)');
	    });

	    Schema::table('visit_todo_groups', function (Blueprint $table) {
		    //
		    $table->integer('fcategory')->default(1)->comment('分类(1-正常巡访方案, 2-组长复巡方案)');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visit_store_todo', function (Blueprint $table) {
            //
	        $table->dropColumn('fcategory');
        });

	    Schema::table('visit_todo_calendar', function (Blueprint $table) {
		    $table->dropColumn('fcategory');
	    });

	    Schema::table('visit_todo_groups', function (Blueprint $table) {
		    //
		    $table->dropColumn('fcategory');
	    });
    }
}
