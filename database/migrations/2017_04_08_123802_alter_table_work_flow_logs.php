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
        });
    }
}
