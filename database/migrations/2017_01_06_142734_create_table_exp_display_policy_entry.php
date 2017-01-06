<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExpDisplayPolicyEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exp_display_policy_entry', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fdisplay_policy_id')->comment('exp_display_policy id');
            $table->integer('fmaterail_id')->comment('exp_display_policy id');
            $table->integer('fmaterail_type')->default(0)->comment('类型  0 正常产品 1 奖励产品 ');

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
        Schema::dropIfExists('exp_display_policy_entry');
    }
}
