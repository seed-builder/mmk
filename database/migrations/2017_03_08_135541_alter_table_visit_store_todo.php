<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVisitStoreTodo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visit_store_todo', function (Blueprint $table) {
            //
	        $table->string('fchildren_calculate')->default('and')->comment('状态改变所依据的子项状态的计算方式（and , or）');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visit_store_todo', function (Blueprint $table) {
            //
	        $table->dropColumn('fchildren_calculate');
        });
    }
}
