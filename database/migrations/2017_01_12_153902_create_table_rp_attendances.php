<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRpAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rp_attendances', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('forg_id')->default(0);
	        $table->integer('femp_id')->default(0);
	        $table->integer('fyear')->default(0)->comment('年份');
	        $table->integer('fmonth')->default(0)->comment('月份');
	        $table->integer('fwork_days')->default(0)->comment('应打卡天数');
	        $table->integer('fnormal_days')->default(0)->comment('正常天数');
	        $table->integer('fabnormal_days')->default(0)->comment('异常天数');

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
        Schema::dropIfExists('rp_attendances');
    }
}
