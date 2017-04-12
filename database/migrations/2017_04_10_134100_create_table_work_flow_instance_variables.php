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
		    $table->integer('work_flow_variable_id');
		    $table->string('name')->comment('变量名（英文）');
		    $table->text('value')->nullable()->comment('变量值');
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
