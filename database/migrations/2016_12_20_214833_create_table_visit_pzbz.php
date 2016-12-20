<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVisitPzbz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_pzbz', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fbill_no')->default('')->comment('bill no');
            $table->string('fremark')->default('')->comment('备注');
            $table->integer('fphoto_id')->default(0)->comment('picture id');
            $table->integer('flog_id')->default(0)->comment('visit_todo_calendar id');
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
        Schema::dropIfExists('visit_pzbz');
    }
}
