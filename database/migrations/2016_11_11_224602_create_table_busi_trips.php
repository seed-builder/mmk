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
            $table->increments('id');
            $table->string('fbillno')->unique();
            $table->integer('forg_id')->default(0);
            $table->integer('femp_id')->default(0);
            $table->integer('farrive_image')->default('');
            $table->timestamp('fout_time')->nullable();
            $table->timestamp('farrive_time')->nullable();
            $table->string('fremark')->default('');
            $table->string('ffile_path')->default('');
            $table->string('ffile_name')->default('');
            $table->string('flongitude')->default('');
            $table->string('flatitude')->default('');
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
        Schema::drop('ms_busi_trips');
    }
}
