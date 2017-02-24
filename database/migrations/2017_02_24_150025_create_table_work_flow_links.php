<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkFlowLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('work_flow_steps', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('work_flow_template_id');
		    $table->integer('source_node_id')->nullable()->comment('上一步节点');
		    $table->integer('target_node_id')->nullable()->comment('下一步节点');
		    $table->string('condition')->nullable()->comment('条件');

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
    }
}
