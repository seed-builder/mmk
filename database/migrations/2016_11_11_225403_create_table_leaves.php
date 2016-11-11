<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLeaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_leaves', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('fbillno')->unique();
            $table->uuid('forg_id');
            $table->uuid('fdept_id');
            $table->uuid('femp_id');
            $table->integer('fask_type')->default(0);
            $table->integer('freason')->default('');
            $table->timestamp('fstart_time');
            $table->timestamp('fend_time');
            $table->integer('flentime');
            $table->string('fremarks')->default('');
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
        Schema::drop('ms_leaves');
    }
}
