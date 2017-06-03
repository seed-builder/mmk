<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBdCustomers2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bd_customers', function (Blueprint $table) {
            //
	        $table->string('flongitude')->nullable()->comment('百度地图经度');
	        $table->string('flatitude')->nullable()->comment('百度地图纬度');
	        $table->string('fstock_address')->nullable()->comment('库存地址');
	        $table->integer('fcheck_limit')->default(0)->comment('限制盘点位置距离（0-不限制，单位：米');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bd_customers', function (Blueprint $table) {
            //
	        $table->dropColumn('flongitude');
	        $table->dropColumn('flatitude');
	        $table->dropColumn('fstock_address');
	        $table->dropColumn('fcheck_limit');
        });
    }
}
