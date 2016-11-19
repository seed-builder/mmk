<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToBdEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('bd_employees', function (Blueprint $table) {
            //
            $table->integer('forg_id')->default(0);
            $table->string('device')->default('');
            $table->integer('login_time')->default(0);
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
        Schema::table('bd_employees', function (Blueprint $table) {
            //
            $table->dropColumn('foreign_table');
            $table->dropColumn('device');
            $table->dropColumn('login_time');
        });
    }
}
