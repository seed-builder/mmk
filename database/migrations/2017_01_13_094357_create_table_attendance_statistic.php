<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAttendanceStatistic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_statistics', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('forg_id')->default(0);
	        $table->integer('femp_id')->default(0);
	        $table->integer('fyear')->default(0)->comment('年份');
	        $table->integer('fmonth')->default(0)->comment('月份');
	        $table->timestamp('fday')->nullable()->comment('日期');
	        $table->timestamp('fbegin')->nullable()->comment('上班时间');
	        $table->integer('fbegin_id')->nullable()->comment('考勤表id');
	        $table->timestamp('fcomplete')->nullable()->comment('下班时间');
	        $table->integer('fcomplete_id')->nullable()->comment('考勤表id');
	        $table->integer('fbegin_status')->default(0)->comment('上班考勤状态(0-未完成, 1-正常, 2-迟到)');
	        $table->integer('fcomplete_status')->default(0)->comment('下班考勤状态(0-未完成, 1-正常, 2-早退)');
	        $table->integer('fstatus')->default(0)->comment('考勤状态(0-未完成, 1-正常, 2-异常, 3-请假)');

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
        Schema::dropIfExists('attendance_statistics');
    }
}
