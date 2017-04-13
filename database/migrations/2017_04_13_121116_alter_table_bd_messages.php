<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBdMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bd_messages', function (Blueprint $table) {
            //
	        $table->integer('type')->default(0)->comment('消息类型（0-系统公告,1-公司发文,2-流程消息,3-任务消息）');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bd_messages', function (Blueprint $table) {
            //
	        $table->dropColumn('type');
        });
    }
}
