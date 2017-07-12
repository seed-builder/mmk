<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStStockOutItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('st_stock_out_items', function (Blueprint $table) {
            //
	        $table->decimal('fprice_box')->default(0.0)->comment('单价/箱');
	        $table->decimal('fprice_bottle')->default(0.0)->comment('单价/瓶');
	        $table->decimal('famount')->default(0.0)->comment('金额');

	        $table->integer('box_qty')->default(0)->comment('箱数量');
	        $table->integer('bottle_qty')->default(0)->comment('瓶数量');
	        $table->integer('present_box_qty')->default(0)->comment('赠送的箱数量');
	        $table->integer('present_bottle_qty')->default(0)->comment('赠送的瓶数量');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('st_stock_out_items', function (Blueprint $table) {
            //
	        $table->dropColumn('fprice_box');
	        $table->dropColumn('fprice_bottle');
	        $table->dropColumn('famount');

	        $table->dropColumn('box_qty');
	        $table->dropColumn('bottle_qty');
	        $table->dropColumn('present_box_qty');
	        $table->dropColumn('present_bottle_qty');
        });
    }
}
