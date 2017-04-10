<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkFlowInstanceVariables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('work_flow_instance_variables', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('work_flow_instance_id');
		    $table->string('name')->unique()->comment('变量名（英文）');
		    $table->string('display_name')->comment('显示名(中文)');
		    $table->text('value')->nullable()->comment('变量值');
		    $table->string('data_type')->comment('数据类型');
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
        //
	    Schema::dropIfExists('work_flow_instance_variables');
    }
}
