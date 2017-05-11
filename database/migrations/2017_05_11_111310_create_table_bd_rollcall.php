<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdRollcall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_rollcalls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('femp_id')->comment('employee id');
            $table->string('faddress')->nullable()->comment('地址');
            $table->string('flongitude')->nullable()->comment('百度地图经度');
            $table->string('flatitude')->nullable()->comment('百度地图纬度');
            $table->string('fphotos')->nullable()->comment('图片id 集合， 逗号隔开');
            $table->string('fmode')->nullable()->comment('模式');
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
        Schema::dropIfExists('bd_rollcalls');
    }
}
