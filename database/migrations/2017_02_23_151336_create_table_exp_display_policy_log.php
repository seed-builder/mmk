<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExpDisplayPolicyLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exp_display_policy_log', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('forg_id')->default(0)->comment('组织id');
	        $table->integer('fpolicy_id')->default(0)->comment('方案id');
	        $table->integer('fpolicy_store_id')->default(0)->comment('签约门店id');
	        $table->integer('femp_id')->default(0)->comment('业务员id');
	        $table->timestamp('fdate')->nullable()->comment('拜访日期');

	        $table->string('fremark')->default('')->comment('备注');
	        $table->string('fphotos')->default('')->comment('图片id 集合， 逗号隔开');
	        $table->integer('flog_id')->default(0)->comment('visit_todo_calendar id');
	        $table->integer('fcreator_id')->default(0)->comment('创建人');
	        $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
	        $table->integer('fmodify_id')->default(0)->comment('修改人');
	        $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
	        $table->string('fdocument_status')->default('A')->comment('审核状态');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exp_display_policy_log');
    }
}
