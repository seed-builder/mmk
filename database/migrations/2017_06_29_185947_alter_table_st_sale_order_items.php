<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStSaleOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('st_sale_order_items', function (Blueprint $table) {
            //
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
        Schema::table('st_sale_order_items', function (Blueprint $table) {
            //
	        $table->dropColumn('box_qty');
	        $table->dropColumn('bottle_qty');
	        $table->dropColumn('present_box_qty');
	        $table->dropColumn('present_bottle_qty');
        });
    }
}
