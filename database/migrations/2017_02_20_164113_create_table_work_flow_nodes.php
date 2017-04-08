<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkFlowNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('work_flow_nodes', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('work_flow_id');
		    $table->char('type', 1)->default('C')->comment('节点类型(F-开始, C-普通审批节点, D-汇签节点, L-结束节点)');
		    $table->string('approver')->nullable()->comment('审批人');
		    $table->integer('approver_type')->nullable()->comment('审批人类型(0-按角色，1-特定人)');
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
	    Schema::dropIfExists('work_flow_nodes');
    }
}
