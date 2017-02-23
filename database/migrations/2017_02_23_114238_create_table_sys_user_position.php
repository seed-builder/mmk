<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSysUserPosition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('sys_user_position', function (Blueprint $table) {
		    $table->integer('user_id');
		    $table->integer('position_id');
//		    $table->foreign('user_id')->references('id')->on('sys_users')
//			    ->onUpdate('cascade')->onDelete('cascade');
//		    $table->foreign('position_id')->references('id')->on('bd_positions')
//			    ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['user_id', 'position_id']);
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
	    Schema::dropIfExists('sys_user_position');
    }
}
