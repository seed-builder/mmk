<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSaleOrderItems extends Migration
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
	        $table->integer('fmaterial_form')->default(1)->comment('产品形态 (1-正常品 2-促销品)');
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
	        $table->dropColumn('fmaterial_form');
        });
    }
}
