<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSysPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_permissions', function (Blueprint $table) {
            //
	        $table->char('type', 1)->default('p')->comment('类型： m-模块, p-页面, f-功能');
	        $table->string('url')->nullable()->comment('');
	        $table->integer('pid')->default(0)->comment('parent id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_permissions', function (Blueprint $table) {
            //
	        $table->dropColumn('type');
	        $table->dropColumn('url');
	        $table->dropColumn('pid');
        });
    }
}
