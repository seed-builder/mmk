<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bd_employees', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('fdept_id');
            $table->uuid('fpost_id');
            $table->string('fname');
            $table->string('fnumber')->unique();
            $table->string('fempnum')->default('');
            $table->string('fphone')->default('');
            $table->string('faddress')->default('');
            $table->string('fremark')->default('');
            $table->uuid('fphoto')->default('');
            $table->string('femail')->unique();
            $table->string('password')->default('');
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
        Schema::drop('employees');
    }
}
