<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkFlowLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('work_flow_logs', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('work_flow_id');
		    $table->integer('work_flow_template_id');
		    $table->string('node_id')->nullable()->comment('审批节点');
		    $table->integer('approver_id')->nullable()->comment('审批人id（user id）');
		    $table->string('action')->nullable()->comment('审批动作');
		    $table->string('remark')->nullable()->comment('备注');
		    $table->timestamps();
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
	    Schema::dropIfExists('work_flow_logs');
    }
}
