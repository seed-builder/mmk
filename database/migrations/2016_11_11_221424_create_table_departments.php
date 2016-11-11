<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bd_departments', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('fnumber')->unique();
            $table->string('fname');
            $table->string('fpardept_id')->default(0);
            $table->string('ffullname')->default('');
            $table->string('fremark')->default('');
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
        Schema::drop('departments');
    }
}
