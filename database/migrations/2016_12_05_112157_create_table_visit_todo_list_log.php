<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVisitTodoListLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('visit_todo_list_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forg_id')->default(0)->comment('组织id');
            $table->timestamp('fdate')->nullable()->comment('日期');
            $table->integer('femp_id')->default(0)->comment('员工id');
            $table->integer('fstore_calendar_id')->default(0)->comment('线路门店巡防日历id');
            $table->integer('ftodo_list_id')->default(0)->comment('门店巡访项目id');
            $table->string('fstatus')->default('')->comment('巡访状态');

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
        Schema::drop('visit_todo_list_log');
    }
}
