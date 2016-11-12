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
            $table->uuid('id');
            $table->string('name');
            $table->string('ext')->default('');
            $table->integer('size')->default(0);
            $table->string('path')->default('');
            $table->string('mimetype')->default('');
            $table->string('res_type')->default('');
            $table->uuid('res_id')->default('');
            $table->uuid('fcreator_id')->default('');
            $table->timestamp('fcreate_date')->nullable();
            $table->uuid('fmodify_id')->default('');
            $table->timestamp('fmodify_date')->nullable();
            $table->uuid('fauditor_id')->default('');
            $table->timestamp('faudit_date')->nullable();
            $table->integer('fdocument_status')->default(0);
            $table->uuid('fforbidder_id')->default('');
            $table->timestamp('fforbid_date')->nullable();
            $table->integer('fforbid_status')->default(0);
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
