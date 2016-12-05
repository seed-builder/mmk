<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEngShiftSlice extends Migration
{
    /**
     * 班次
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('eng_shift_slice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fnumber')->default('')->comment('编号');
            $table->string('fname')->default('')->comment('名称');
            $table->decimal('fwork_hours')->default(4)->comment('工作时间');
            $table->timestamp('fexpire_date')->nullable()->comment('失效时间');
            $table->timestamp('feffect_date')->nullable()->comment('生效时间');
            $table->integer('fcreate_org_id')->default(0)->comment('创建组织id');
            $table->integer('fuse_org_id')->default(0)->comment('使用组织id');
            $table->integer('fcreator_id')->default(0)->comment('创建人');
            $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
            $table->integer('fmodify_id')->default(0)->comment('修改人');
            $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
            $table->integer('fauditor_id')->default(0)->comment('审核人');
            $table->timestamp('faudit_date')->nullable()->comment('审核日期');
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
        Schema::drop('eng_shift_slice');
    }
}
