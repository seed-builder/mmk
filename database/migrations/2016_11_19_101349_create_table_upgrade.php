<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUpgrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sys_upgrades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('version_code');
            $table->string('version_name');
            $table->string('url')->default('');
            $table->text('content');
            $table->string('upgrade_date')->default('');
            $table->integer('enforce')->default(0);
            $table->string('type')->default('android');
            $table->timestamps();
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
        Schema::drop('sys_upgrades');
    }
}
