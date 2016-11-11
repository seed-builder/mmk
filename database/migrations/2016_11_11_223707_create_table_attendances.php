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
            $table->string('flongitude')->default('');
            $table->string('flatitude')->default('');
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
        Schema::drop('ms_attendances');
    }
}
