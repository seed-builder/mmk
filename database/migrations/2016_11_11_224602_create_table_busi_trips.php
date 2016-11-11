<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBusiTrips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_busi_trips', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('fbillno')->unique();
            $table->uuid('forg_id');
            $table->uuid('femp_id');
            $table->uuid('farrive_image')->default('');
            $table->integer('fdocument_status')->default(0);
            $table->timestamp('fout_time')->nullable();
            $table->timestamp('farrive_time')->nullable();
            $table->string('fremark')->default('');
            $table->string('ffile_path')->default('');
            $table->string('ffile_name')->default('');
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
        //
        Schema::drop('busi_trips');
    }
}
