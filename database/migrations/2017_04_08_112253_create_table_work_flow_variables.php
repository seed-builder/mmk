<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkFlowVariables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('work_flow_instances', function (Blueprint $table) {
		    //
		    $table->dropColumn('approver_id');
		    $table->string('bill_no')->comment('单号');
	    });

        Schema::create('work_flow_variables', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('work_flow_id');
	        $table->string('name')->unique()->comment('变量名（英文）');
	        $table->string('display_name')->comment('显示名(中文)');
	        $table->string('value')->comment('默认变量值');
	        $table->string('data_type')->comment('数据类型');
	        $table->integer('categroy')->default(0)->comment('所属类型(0-公共变量, 1-私有变量)');

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
	    Schema::table('work_flow_instances', function (Blueprint $table) {
		    //
		    $table->integer('approver_id')->nullabel();
		    $table->dropColumn('bill_no');
	    });
        Schema::dropIfExists('work_flow_variables');
    }
}
