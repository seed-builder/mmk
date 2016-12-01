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
            $table->increments('id');
            $table->integer('fdept_id')->default(0);
            $table->integer('fpost_id')->default(0);
            $table->string('fname');
            $table->string('fnumber')->default('');
            $table->string('femp_num')->default('');
            $table->string('fphone')->unique();
            $table->string('faddress')->default('');
            $table->string('fremark')->default('');
            $table->integer('fphoto')->default(0);
            $table->string('femail')->default('');
            $table->string('fpassword')->default('');
            $table->integer('fcreator_id')->default(0);
            $table->timestamp('fcreate_date')->nullable();
            $table->integer('fmodify_id')->default(0);
            $table->timestamp('fmodify_date')->nullable();
            $table->integer('fauditor_id')->default(0);
            $table->timestamp('faudit_date')->nullable();
            $table->string('fdocument_status')->default('A');
            $table->integer('fforbidder_id')->default(0);
            $table->timestamp('fforbid_date')->nullable();
            $table->string('fforbid_status')->default('A');

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
        Schema::drop('bd_employees');
    }
}
