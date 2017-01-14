<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBdChannels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_channels', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('fnumber')->default('')->comment('渠道编码');
	        $table->string('fname')->default('')->comment('渠道名称');
	        $table->integer('fgroup_id')->default(0)->comment('渠道所属分组id');
	        $table->string('fremark')->default('')->comment('渠道定义');
	        $table->integer('fsort')->default(0)->comment('排序');

	        $table->integer('fcreator_id')->default(0)->comment('创建人');
	        $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
	        $table->integer('fmodify_id')->default(0)->comment('修改人');
	        $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
	        $table->string('fdocument_status')->default('A')->comment('数据状态');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bd_channels');
    }
}
