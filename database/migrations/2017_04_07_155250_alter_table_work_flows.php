<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWorkFlows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_flows', function (Blueprint $table) {
            //
	        $table->renameColumn('table', 'desc')->nullable()->comment('描述');
	        $table->integer('msg_template_id')->nullable();
	        $table->string('email_template_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_flows', function (Blueprint $table) {
            //
	        $table->dropColumn('msg_template_id');
	        $table->dropColumn('email_template_id');
	        $table->renameColumn('desc', 'table');
        });
    }
}
