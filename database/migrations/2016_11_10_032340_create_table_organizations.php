<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrganizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bd_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fnumber')->unique();
            $table->string('fname');
            $table->string('ffullname')->default('');
            $table->string('faddress')->default('');
            $table->string('fcontacts')->default('');
            $table->string('fphone')->default('');
            $table->string('fowner')->default('');
            //$table->timestamps();
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
        Schema::drop('bd_organizations');
    }
}
