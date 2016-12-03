<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEngShiftSliceData extends Migration
{
    /**
     * Run the migrations.
     * 工作时段
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('eng_shift_slice_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fentry_id')->comment('eng_shift_slice id');
            $table->integer('fseq')->default(0)->comment('排序');
            $table->timestamp('fstart_time')->nullable()->comment('开始时间');
            $table->timestamp('fend_time')->nullable()->comment('结束时间');
            $table->decimal('fhours')->default(0)->comment('小时数');
            $table->string('fremarks')->default('')->comment('备注');
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
        Schema::drop('eng_shift_slice_data');
    }
}
