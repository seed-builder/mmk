<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVisitLineStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_line_store', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fline_id')->default(0)->comment('线路id');
            $table->integer('fstore_id')->default(0)->comment('门店id');
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('visit_line_store');
    }
}
