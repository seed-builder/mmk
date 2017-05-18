<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBdPriceGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bd_price_groups', function (Blueprint $table) {
            //
	        $table->integer('fis_all')->default(0)->comment('是否适用全部');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bd_price_groups', function (Blueprint $table) {
            //
	        $table->dropColumn('fis_all');
        });
    }
}
