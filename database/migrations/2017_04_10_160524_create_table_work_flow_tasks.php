<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkFlowTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_flow_tasks', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('work_flow_id');
	        $table->integer('work_flow_instance_id');
	        $table->integer('approver_id')->nullable()->comment('审批人id（user id）');
	        $table->string('action')->nullable()->comment('审批动作');
	        $table->string('remark')->nullable()->comment('备注');
	        $table->integer('status')->default(0)->comment('处理状态（0-未处理，1-已经处理， 2-被撤销, 3-非正常结束）');
	        $table->integer('link_id')->default(0)->comment('work flow link id');
	        $table->integer('pre_task_id')->default(0)->comment('pre task id');
	        $table->integer('node_id')->default(0)->comment('work flow node id');
	        $table->uuid('uid')->default('')->comment('guid');
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
        Schema::dropIfExists('work_flow_tasks');
    }
}
