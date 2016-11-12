<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bd_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ext')->default('');
            $table->integer('size')->default(0);
            $table->string('path')->default('');
            $table->string('mimetype')->default('');
            $table->string('res_type')->default('');
            $table->integer('res_id')->default('');
            $table->integer('fcreator_id')->default('');
            $table->timestamp('fcreate_date')->nullable();
            $table->integer('fmodify_id')->default('');
            $table->timestamp('fmodify_date')->nullable();
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
        Schema::drop('bd_resources');
    }
}
