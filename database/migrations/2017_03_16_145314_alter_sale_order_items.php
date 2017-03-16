<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSaleOrderItems extends Migration
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
	        $table->char('fsend_status', 1)->default('A')->comment('发货状态（A-未配送,C-已配送）');
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
	        $table->dropColumn('fsend_status');
        });
    }
}
