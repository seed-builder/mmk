<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWorkFlowInstances3 extends Migration
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
	        $table->dropColumn('node_id');
	        $table->dropColumn('data_type');
	        $table->dropColumn('data_id');
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
	        $table->integer('data_id')->nullable()->comment('数据 id');
	        $table->integer('node_id')->nullable()->comment('node id');
	        $table->string('data_type')->nullable()->comment('数据类型');
        });
    }
}
