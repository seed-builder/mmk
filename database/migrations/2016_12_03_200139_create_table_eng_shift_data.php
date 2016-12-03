<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEngShiftData extends Migration
{
    /**
     * 班制明细
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('eng_shift_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fentry_id')->comment('eng_shift id');
            $table->integer('fshift_slice_id')->comment('eng_shift_slice id');
            $table->integer('fseq')->default(0)->comment('排序');
            $table->integer('fis_first_period')->default(0)->comment('是否第一个班次');
            $table->string('fnumber')->default('')->comment('编码');
            $table->string('fname')->default('')->comment('名称');
            $table->timestamp('fstart_time')->nullable()->comment('开始时间');
            $table->timestamp('fend_time')->nullable()->comment('结束时间');
            $table->decimal('fhours')->default(0)->comment('小时数');

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
        Schema::drop('eng_shift_data');
    }
}
