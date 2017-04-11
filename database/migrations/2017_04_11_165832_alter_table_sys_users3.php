<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSysUsers3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_users', function (Blueprint $table) {
            //
	        $table->string('nick_name')->default('')->comment('nick name');
	        $table->string('logo')->default('')->comment('logo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_users', function (Blueprint $table) {
            //
	        $table->dropColumn('nick_name');
	        $table->dropColumn('logo');
        });
    }
}
