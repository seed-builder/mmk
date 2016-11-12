<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_attendances', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('fbillno')->unique();
            $table->uuid('forg_id');
            $table->uuid('femp_id');
            $table->timestamp('ftime')->nullable();
            $table->string('fremark')->default('');
            $table->string('faddress')->default('');
            $table->string('fphoto')->default('');
            $table->integer('ftype')->default(0);
            $table->integer('fmode')->default(0);
            $table->string('flongitude')->default('');
            $table->string('flatitude')->default('');
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
        Schema::drop('ms_attendances');
    }
}
