<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('st_stores', function (Blueprint $table) {
            //
	        $table->integer('fis_signed')->default(0)->comment('是否签约');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('st_stores', function (Blueprint $table) {
            //
	        $table->dropColumn('fis_signed');
        });
    }
}
