<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEngWorkCalendarData extends Migration
{
    /**
     * 工作日历明细
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('eng_work_calendar_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fwork_calendar_id')->comment('eng_work_calendar id');
            $table->integer('fshift_id')->comment('eng_shift 班制id');
            $table->integer('fseq')->default(0)->comment('排序');
            $table->timestamp('fday')->nullable()->comment('日期');
            $table->integer('fday_id')->default(0)->comment('fday_id');
            $table->integer('fweek_id')->default(0)->comment('fweek_id');
            $table->integer('fmonth_id')->default(0)->comment('fmonth_id');
            $table->integer('fyear_id')->default(0)->comment('fyear_id');
            $table->timestamp('fpre_day')->nullable()->comment('前一天');
            $table->integer('fpre_id')->default(0)->comment('后一天');
            $table->timestamp('fnext_day')->nullable()->comment('后一天');
            $table->char('fis_work_time', 1)->default('0')->comment('是否工作日');
            $table->char('fresqty', 1)->default('0')->comment('');
            $table->char('fdate_style', 1)->default('1')->comment('日期类型');
            $table->integer('fcreator_id')->default(0)->comment('创建人');
            $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
            $table->integer('fmodify_id')->default(0)->comment('修改人');
            $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
            $table->string('fdocument_status')->default('A')->comment('审核状态');

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
        Schema::drop('eng_work_calendar_data');
    }
}
