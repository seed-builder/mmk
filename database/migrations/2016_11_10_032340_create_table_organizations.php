<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdOrganization extends Migration
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
            $table->uuid('id');
            $table->string('fnumber')->unique();
            $table->string('fname');
            $table->string('ffullname')->default('');
            $table->string('faddress')->default('');
            $table->string('fcontacts')->default('');
            $table->string('fphone')->default('');
            $table->string('fowner')->default('');
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
        Schema::drop('organizations');
    }
}
