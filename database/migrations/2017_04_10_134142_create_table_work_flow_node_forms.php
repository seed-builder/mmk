<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkFlowNodeForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('work_flow_node_forms', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('node_id');
		    $table->text('content')->nullable()->comment('form content');
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
	    Schema::dropIfExists('work_flow_node_forms');
    }
}
