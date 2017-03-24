<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBdEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bd_employees', function (Blueprint $table) {
            //
	        $table->integer('fcust_id')->default(0)->comment('经销商id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bd_employees', function (Blueprint $table) {
            //
	        $table->dropColumn('fcust_id');
        });
    }
}
