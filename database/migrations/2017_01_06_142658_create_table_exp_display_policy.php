<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExpDisplayPolicy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exp_display_policy', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('forg_id')->default(0)->comment('组织id');
	        $table->string('fbill_no')->default('')->comment('bill no');
	        $table->string('fexp_type')->default('')->comment('费用类别');
	        $table->timestamp('fstart_date')->nullable()->comment('执行开始日期');
	        $table->timestamp('fend_date')->nullable()->comment('执行结束日期 ');
	        $table->integer('fcost_dept_id')->default(0)->comment('应用区域(部门 id)');
	        $table->decimal('famount')->default(0)->comment('总金额');
	        $table->string('fsketch')->default('')->comment('项目简述');
	        $table->integer('fact_store_num')->default(0)->comment('执行门店总数');
	        $table->decimal('fstore_cost_limit')->default(0)->comment('单个门店费用上限');
	        $table->integer('fsign_store_num')->default(0)->comment('已签约门店总数');
	        $table->integer('fsign_amount')->default(0)->comment('已签约总金额');

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
        Schema::dropIfExists('exp_display_policy');
    }
}
