<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AltertTableWorkFlows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_flows', function (Blueprint $table) {
            //
	        $table->integer('default_task_approver_id')->nullable()->comment('任务缺省处理人id');
//	        $table->string('default_task_approver')->nullable()->comment('任务缺省处理人');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_flows', function (Blueprint $table) {
            //
	        $table->dropColumn('default_task_approver_id');
//	        $table->dropColumn('default_task_approver');
        });
    }
}
