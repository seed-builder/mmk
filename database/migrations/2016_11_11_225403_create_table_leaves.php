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
            $table->increments('id');
            $table->string('fbillno')->unique();
            $table->integer('forg_id')->default(0);
            $table->integer('fdept_id')->default(0);
            $table->integer('femp_id')->default(0);
            $table->integer('fask_type')->default(0);
            $table->string('freason')->default('');
            $table->timestamp('fstart_time')->nullable();
            $table->timestamp('fend_time')->nullable();
            $table->integer('flentime')->default(0);
            $table->string('fremarks')->default('');
            $table->integer('fcreator_id')->default('');
            $table->timestamp('fcreate_date')->nullable();
            $table->integer('fmodify_id')->default('');
            $table->timestamp('fmodify_date')->nullable();
            $table->integer('fauditor_id')->default('');
            $table->timestamp('faudit_date')->nullable();
            $table->integer('fdocument_status')->default(0);
            $table->integer('fforbidder_id')->default('');
            $table->timestamp('fforbid_date')->nullable();
            $table->string('fforbid_status')->default(0);
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
