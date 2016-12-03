<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEngWorkCalendar extends Migration
{
    /**
     * 工作日历
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('eng_work_calendar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fform_id')->nullable()->comment('');
            $table->integer('fmaster_id')->default(0)->comment('组id');
            $table->string('fnumber')->default('')->comment('编号');
            $table->string('fname')->default('')->comment('名称');
            $table->integer('fcreate_org_id')->default(0)->comment('创建组织id');
            $table->integer('fuse_org_id')->default(0)->comment('使用组织id');
            $table->integer('fwork_calendar_template_id')->default(0)->comment('模板id');
            $table->string('fcal_user_type')->nullable()->comment('');
            $table->string('fcal_user_id')->nullable()->comment('');
            $table->string('fstd_cal_id')->nullable()->comment('');
            $table->string('fis_system_set')->default('')->comment('是否系统设置');
            $table->integer('fcreator_id')->default(0)->comment('创建人');
            $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
            $table->integer('fmodify_id')->default(0)->comment('修改人');
            $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
            $table->integer('fauditor_id')->default(0)->comment('审核人');
            $table->timestamp('faudit_date')->nullable()->comment('审核日期');
            $table->string('fdocument_status')->default('A')->comment('审核状态');
            $table->integer('fforbidder_id')->default(0)->comment('禁用人');
            $table->timestamp('fforbid_date')->nullable()->comment('禁用日期');
            $table->string('fforbid_status')->default('A')->comment('禁用状态');


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
        Schema::drop('eng_work_calendar');
    }
}
