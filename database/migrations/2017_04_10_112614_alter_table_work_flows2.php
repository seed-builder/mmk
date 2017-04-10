<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWorkFlows2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('work_flows', function (Blueprint $table) {
		    $table->uuid('uid')->default('')->comment('guid');
	    });
	    Schema::table('work_flow_nodes', function (Blueprint $table) {
		    $table->uuid('uid')->default('')->comment('guid');
	    });
	    Schema::table('work_flow_links', function (Blueprint $table) {
		    $table->uuid('uid')->default('')->comment('guid');
	    });
	    Schema::table('work_flow_variables', function (Blueprint $table) {
		    $table->uuid('uid')->default('')->comment('guid');
	    });
	    Schema::table('work_flow_logs', function (Blueprint $table) {
		    $table->uuid('uid')->default('')->comment('guid');
	    });
	    Schema::table('work_flow_instances', function (Blueprint $table) {
		    $table->uuid('uid')->default('')->comment('guid');
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
	    Schema::table('work_flows', function (Blueprint $table) {
		    $table->dropColumn('uid');
	    });
	    Schema::table('work_flow_nodes', function (Blueprint $table) {
		    $table->dropColumn('uid');
	    });
	    Schema::table('work_flow_links', function (Blueprint $table) {
		    $table->dropColumn('uid');
	    });
	    Schema::table('work_flow_variables', function (Blueprint $table) {
		    $table->dropColumn('uid');
	    });
	    Schema::table('work_flow_logs', function (Blueprint $table) {
		    $table->dropColumn('uid');
	    });
	    Schema::table('work_flow_instances', function (Blueprint $table) {
		    $table->dropColumn('uid');
	    });
    }
}
