<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStStockChecks2 extends Migration
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
	        $table->integer('fyear')->nullable()->comment('年份');
	        $table->integer('fmonth')->nullable()->comment('年份');
	        $table->timestamp('fcomplete_date')->nullable()->comment('完成日期');
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
	        $table->dropColumn('fyear');
	        $table->dropColumn('fmonth');
	        $table->dropColumn('fcomplete_date');
        });
    }
}
