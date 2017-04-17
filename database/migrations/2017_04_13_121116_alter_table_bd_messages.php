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
	        $table->integer('extra_id')->nullable()->comment('附加数据id');
	        $table->string('extra_type')->nullable()->comment('附加数据类型');

        });
	    Schema::table('bd_message_contents', function (Blueprint $table) {
		    //
		    $table->integer('type')->default(0)->comment('消息类型（0-系统公告,1-公司发文,2-流程消息,3-任务消息）');
		    $table->string('subtitle')->nullable()->comment('副标题');
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
	        $table->dropColumn('extra_id');
	        $table->dropColumn('extra_type');

        });

	    Schema::table('bd_message_contents', function (Blueprint $table) {
		    //
		    $table->dropColumn('type');
		    $table->dropColumn('subtitle');
	    });
    }
}
