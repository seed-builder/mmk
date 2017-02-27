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
		    $table->char('type', 1)->default('C')->comment('节点类型(F-first, C-common, L-last)');
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
