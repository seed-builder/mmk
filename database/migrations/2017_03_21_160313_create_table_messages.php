<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_id')->default(0);
            $table->string('from_type');
            $table->integer('to_id')->default(0);
            $table->string('to_type');
            $table->timestamp('send_time');
            $table->integer('read')->default(0);
            $table->string('title');
            $table->string('content');
            $table->string('file');
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
        Schema::dropIfExists('message');
    }
}
