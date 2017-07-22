<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdCarousels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_carousels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fseq')->default(0)->comment('排序');
            $table->string('fname')->nullable()->comment('图片名称');
            $table->integer('fpicture_id')->nullable()->comment('图片id');
	        $table->timestamp('fcreate_date')->nullable();
	        $table->timestamp('fmodify_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bd_carousels');
    }
}
