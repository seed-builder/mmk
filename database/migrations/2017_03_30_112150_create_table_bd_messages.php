<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_messages', function (Blueprint $table) {
		        $table->increments('id');
		        $table->integer('from_id')->default(0);
		        $table->string('from_type')->default('');
		        $table->integer('to_id')->default(0);
		        $table->string('to_type')->default('');
		        $table->integer('message_content_id')->default(0);
		        $table->integer('read')->default(0);
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
        Schema::dropIfExists('bd_messages');
    }
}
