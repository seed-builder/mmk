<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkFlows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('work_flows', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('work_flow_template_id');
		    $table->string('sponsor')->nullable()->comment('发起人');
		    $table->string('node_id')->nullable()->comment('当前所处审批节点');
		    $table->string('table')->nullable()->comment('数据表');
		    $table->integer('data_id')->nullable()->comment('数据 id');
		    $table->integer('approver_id')->nullable()->comment('审批人id（user id）');
		    $table->integer('status')->default(0)->comment('状态(0-审批中,1-结束)');
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
	    Schema::dropIfExists('work_flows');
    }
}
