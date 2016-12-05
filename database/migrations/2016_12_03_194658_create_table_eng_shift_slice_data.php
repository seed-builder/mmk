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
            $table->integer('fshift_slice_id')->comment('eng_shift_slice id');
            $table->integer('fseq')->default(0)->comment('排序');
            $table->timestamp('fstart_time')->nullable()->comment('开始时间');
            $table->timestamp('fend_time')->nullable()->comment('结束时间');
            $table->decimal('fhours')->default(0)->comment('小时数');
            $table->string('fremarks')->default('')->comment('备注');
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
        Schema::drop('eng_shift_slice_data');
    }
}
