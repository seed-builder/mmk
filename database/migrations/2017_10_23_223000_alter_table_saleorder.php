<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSaleorder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('st_sale_orders', function (Blueprint $table) {
            //
            $table->timestamp('fsend_date')->nullable()->comment('发货时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('st_sale_orders', function (Blueprint $table) {
            //
            $table->dropColumn('fsend_date');
        });
    }
}
