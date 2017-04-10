<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWorkFlowNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_flow_nodes', function (Blueprint $table) {
            //
	        $table->string('title')->default('')->comment('标题');
	        $table->string('desc')->default('')->comment('描述');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_flow_nodes', function (Blueprint $table) {
            //
	        $table->dropColumn('title');
	        $table->dropColumn('desc');
        });
    }
}
