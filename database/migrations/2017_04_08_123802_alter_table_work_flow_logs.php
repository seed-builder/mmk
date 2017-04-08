<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWorkFlowLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_flow_logs', function (Blueprint $table) {
            //
	        $table->integer('status')->default(0)->comment('处理状态（0-未处理，1-已经处理）');
	        //$table->integer('link_id')->default(0)->comment('work flow link id');
	        $table->integer('pre_log_id')->default(0)->comment('pre log id');
	        $table->integer('node_id')->default(0)->comment('work flow node id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_flow_logs', function (Blueprint $table) {
            //
	        $table->dropColumn('status');
	        $table->dropColumn('link_id');
	        $table->dropColumn('pre_log_id');
        });
    }
}
