<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStStockIns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('st_stock_ins', function (Blueprint $table) {
            //
	        $table->integer('total_qty')->default(0)->comment('合计数量');
	        $table->decimal('total_amount')->default(0)->comment('合计金额');
        });
	    Schema::table('st_stock_in_items', function (Blueprint $table) {
		    //
		    $table->decimal('price')->default(0)->comment('单价');
		    $table->decimal('amount')->default(0)->comment('金额');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('st_stock_ins', function (Blueprint $table) {
		    //
		    $table->dropColumn('total_qty');
		    $table->dropColumn('total_amount');
	    });
	    Schema::table('st_stock_in_items', function (Blueprint $table) {
		    //
		    $table->dropColumn('price');
		    $table->dropColumn('amount');
	    });
    }
}
