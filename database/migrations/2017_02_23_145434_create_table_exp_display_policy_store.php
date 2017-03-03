<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExpDisplayPolicyStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exp_display_policy_store', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('forg_id')->default(0)->comment('组织id');
	        $table->string('fbill_no')->default('')->comment('bill no');
	        $table->integer('fpolicy_id')->default(0)->comment('方案id');
	        $table->integer('femp_id')->default(0)->comment('业务员id');
	        $table->timestamp('fstart_date')->nullable()->comment('门店方案执行开始日期');
	        $table->timestamp('fend_date')->nullable()->comment('门店方案执行结束日期 ');
	        $table->integer('fcost_dept_id')->default(0)->comment('应用区域(部门 id)');
	        $table->decimal('famount')->default(0)->comment('费用总金额');
	        $table->string('fsketch')->default('')->comment('项目简述');
	        $table->integer('fstore_id')->default(0)->comment('门店id');
	        $table->decimal('fsign_amount')->default(0)->comment('签约金额');
	        $table->decimal('fcheck_amount')->default(0)->comment('核定签约金额');
	        $table->integer('fcheck_status')->default(0)->comment('验证状态');
	        $table->integer('fstatus')->default(0)->comment('签约状态');
	        $table->timestamp('fdate')->nullable()->comment('签约日期');
	        $table->string('fphotos')->nullable()->comment('图片id 集合， 逗号隔开');

	        $table->integer('fcreator_id')->default(0)->comment('创建人');
	        $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
	        $table->integer('fmodify_id')->default(0)->comment('修改人');
	        $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
	        $table->string('fdocument_status')->default('A')->comment('数据状态(A 是创建 B是审核中 C是已审核 D是重新审核)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exp_display_policy_store');
    }
}
