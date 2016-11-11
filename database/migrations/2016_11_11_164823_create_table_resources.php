<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Resources', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('ext')->default('');
            $table->integer('size')->default(0);
            $table->string('path')->default('');
            $table->string('mimetype')->default('');
            $table->string('res_type')->default('');
            $table->uuid('res_id')->default('');
            $table->timestamps();
            $table->primary('id');
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
        Schema::drop('Resources');
    }
}
