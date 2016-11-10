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
        Schema::create('bd_organization', function (Blueprint $table) {
            $table->string('id');
            $table->string('fnumber')->nullable();
            $table->string('fname')->nullable();
            $table->string('ffullname')->nullable();
            $table->string('faddress')->nullable();
            $table->string('fcontacts')->nullable();
            $table->string('fphone')->nullable();
            $table->string('fowner')->nullable();
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
        Schema::drop('bd_organization');
    }
}
