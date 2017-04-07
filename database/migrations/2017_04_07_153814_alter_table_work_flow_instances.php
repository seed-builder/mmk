<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWorkFlowInstances extends Migration
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
	        $table->renameColumn('table', 'data_type');
	        $table->integer('sponsor_id')->default(0)->comment('发起人id');
	        $table->string('title')->default('')->comment('标题');
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
	        $table->renameColumn('data_type', 'table');
	        $table->dropColumn('title');
	        $table->dropColumn('sponsor_id');
        });
    }
}
