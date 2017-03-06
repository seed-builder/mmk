<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBdPositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bd_positions', function (Blueprint $table) {
            //
	        $table->string('flag')->nullable()->comment('路径标识');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bd_positions', function (Blueprint $table) {
            //
	        $table->dropColumn('flag');
        });
    }
}
