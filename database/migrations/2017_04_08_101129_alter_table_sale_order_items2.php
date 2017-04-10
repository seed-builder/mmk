<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSaleOrderItems2 extends Migration
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
	        $table->decimal('fpresent_qty')->default(0)->comment('赠送品数量');
	        $table->decimal('fpresent_base_qty')->default(0)->comment('赠送品基本单位数量');
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
	        $table->dropColumn('fpresent_qty');
	        $table->dropColumn('fpresent_base_qty');
        });
    }
}
