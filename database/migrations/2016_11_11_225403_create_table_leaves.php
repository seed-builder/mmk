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
            $table->string('freason')->default('');
            $table->timestamp('fstart_time')->nullable();
            $table->timestamp('fend_time')->nullable();
            $table->integer('flentime')->default(0);
            $table->string('fremarks')->default('');
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
        Schema::drop('ms_leaves');
    }
}
