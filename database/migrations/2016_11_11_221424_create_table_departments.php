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
            $table->increments('id');
            $table->string('fnumber')->unique();
            $table->string('fname');
            $table->integer('fpardept_id')->default(0);
            $table->string('ffullname')->default('');
            $table->string('fremark')->default('');

            $table->integer('fcreator_id')->default(0);
            $table->timestamp('fcreate_date')->nullable();
            $table->integer('fmodify_id')->default(0);
            $table->timestamp('fmodify_date')->nullable();
            $table->integer('fauditor_id')->default(0);
            $table->timestamp('faudit_date')->nullable();
            $table->integer('fdocument_status')->default(0);
            $table->integer('fforbidder_id')->default(0);
            $table->timestamp('fforbid_date')->nullable();
            $table->integer('fforbid_status')->default(0);

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
        Schema::drop('bd_departments');
    }
}
