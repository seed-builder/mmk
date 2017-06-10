<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStStockChecks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('st_stock_checks', function (Blueprint $table) {
            //
	        $table->string('fphotos')->default('')->comment('图片id（多个，逗号隔开）');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('st_stock_checks', function (Blueprint $table) {
            //
	        $table->dropColumn('fphotos');
        });
    }
}
