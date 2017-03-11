<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('st_stocks', function (Blueprint $table) {
            //
	        $table->integer('femp_id')->default(0)->comment('employee id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('st_stocks', function (Blueprint $table) {
            //
	        $table->dropColumn('femp_id');
        });
    }
}
