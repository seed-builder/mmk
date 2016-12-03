<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMessageTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bd_message_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('content')->comment('内容模板，变量（#name）');
            $table->integer('type')->default(0)->comment('消息模板类型： 0-jpush 推送');
            $table->timestamp('fcreate_date')->nullable();
            $table->timestamp('fmodify_date')->nullable();

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
        Schema::drop('bd_message_templates');
    }
}
