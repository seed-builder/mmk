<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSysuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('sys_users', function (Blueprint $table) {
            //
            $table->string('device')->nullable()->comment('设备');
            $table->string('device_sn')->nullable()->comment('设备号');
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
        Schema::table('sys_users', function (Blueprint $table) {
            //
            $table->dropColumn('device');
            $table->dropColumn('device_sn');
        });
    }
}
