<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSysUsers2 extends Migration
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
	        $table->dropColumn('femp_id');
	        $table->integer('login_time')->default(0);
	        $table->integer('status')->default(1)->comment('状态(0-禁用,1-启用');
	        $table->integer('reference_id')->nullable();
	        $table->string('reference_type')->nullable();
	        $table->string('name')->unique()->change();
	        $table->string('email')->nullable()->change();
//	        $table->dropIndex('sys_users_email_unique');
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
	        $table->dropColumn('reference_id');
	        $table->dropColumn('reference_type');
	        $table->dropColumn('login_time');
	        $table->integer('femp_id')->nullable();
	        $table->dropIndex('sys_users_name_unique');
        });
    }
}
