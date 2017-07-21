<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStSaleOrders2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('st_sale_orders', function (Blueprint $table) {
            //
	        $table->decimal('ftotal_amount')->default(0.0)->comment('金额');
        });

	    Schema::table('st_sale_order_items', function (Blueprint $table) {
		    //
		    $table->decimal('fprice_box')->default(0.0)->comment('单价/箱');
		    $table->decimal('fprice_bottle')->default(0.0)->comment('单价/瓶');
		    $table->decimal('famount')->default(0.0)->comment('金额');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('st_sale_orders', function (Blueprint $table) {
            //
	        $table->dropColumn('ftotal_amount');
        });

	    Schema::table('st_sale_order_items', function (Blueprint $table) {
		    $table->dropColumn('fprice_box');
		    $table->dropColumn('fprice_bottle');
		    $table->dropColumn('famount');
	    });

    }
}
