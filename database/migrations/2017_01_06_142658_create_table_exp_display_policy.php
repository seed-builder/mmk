<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExpDisplayPolicy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exp_display_policy', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('forg_id')->default(0)->comment('组织id');
	        $table->integer('flog_id')->default(0)->comment('visit_todo_calendar id');
	        $table->integer('fstore_id')->default(0)->comment('门店 id');
	        $table->integer('fcust_id')->default(0)->comment('客户 id');
            $table->string('fbill_no')->default('')->comment('bill no');
            $table->string('fcaption')->default('')->comment('陈列主题');
            $table->string('frequire')->default('')->comment('陈列要求');
            $table->timestamp('fvalid_begin')->nullable()->comment('有效期起');
            $table->timestamp('fvalid_end')->nullable()->comment('有效期止');
	        $table->timestamp('fstart_date')->nullable()->comment('执行开始日期');
	        $table->timestamp('ffinish_date')->nullable()->comment('执行结束日期 ');
	        $table->integer('fdays')->default(0)->comment('天数');
	        $table->string('freward_method')->default('')->comment('奖励方式');
	        $table->decimal('freward_amount')->default(0)->comment('奖励金额');
	        $table->integer('fstatus')->default(0)->comment('执行状态：0 未执行，1执行中 2已执行');

	        $table->integer('fcreator_id')->default(0)->comment('创建人');
	        $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
	        $table->integer('fmodify_id')->default(0)->comment('修改人');
	        $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
	        $table->string('fdocument_status')->default('A')->comment('数据状态');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exp_display_policy');
    }
}
