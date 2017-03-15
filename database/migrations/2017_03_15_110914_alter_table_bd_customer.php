<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBdCustomer extends Migration
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
	        $table->integer('fsale_area_id')->default(0)->comment('所属销售片区');
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
	        $table->dropColumn('fsale_area_id');
        });
    }
}
