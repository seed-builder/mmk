<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableBdEmployees extends Migration
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
	        $table->timestamp('fstart_date')->nullable()->comment('入职日期');
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
	        $table->dropColumn('fstart_date');
        });
    }
}
