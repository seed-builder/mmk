<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEngWorkCalendarTemplateData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('eng_calendar_template_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fentry_id')->comment('eng_calendar_template id');
            $table->integer('fshift_id')->nullable()->comment('eng_shift id');
            $table->integer('fseq')->default(0)->comment('排序');
            $table->integer('frule_type')->default(0)->comment('规则类型');
            $table->integer('fpriority_id')->default(0)->comment('优先级');
            $table->integer('fweek_id')->default(0)->comment('星期几');
            $table->integer('fday_id')->default(0)->comment('月中的第几天');
            $table->integer('fmonth_id')->default(0)->comment('月份');
            $table->char('fis_work_time', 1)->default('0')->comment('是否工作日');
            $table->char('fdate_style', 1)->default('1')->comment('日期类型');
            $table->timestamp('ffix_date')->nullable()->comment('固定日期');
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
        Schema::create('eng_calendar_template_data');
    }
}
