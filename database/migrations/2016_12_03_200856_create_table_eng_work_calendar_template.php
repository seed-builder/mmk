<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEngWorkCalendarTemplate extends Migration
{
    /**
     * 工作日历模板
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //
        Schema::create('eng_calendar_template', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fnumber')->default('')->comment('编号');
            $table->string('fname')->default('')->comment('名称');
            //$table->decimal('fwork_hours')->default(4)->comment('工作时间');
            $table->timestamp('fexpire_date')->nullable()->comment('失效时间');
            $table->timestamp('feffect_date')->nullable()->comment('生效时间');
            $table->integer('forg_id')->default(0)->comment('组织id');
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
        Schema::drop('eng_calendar_template');
    }
}
