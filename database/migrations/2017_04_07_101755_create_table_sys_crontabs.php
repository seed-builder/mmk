<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSysCrontabs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_crontabs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('名称');
            $table->string('command')->default('')->comment('命令');
            $table->string('desc')->default('')->comment('描述');
            $table->timestamp('exec_time')->nullable()->comment('最近一次运行时间');
            $table->text('exec_remark')->nullable()->comment('最近一次运行状态备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_crontabs');
    }
}
