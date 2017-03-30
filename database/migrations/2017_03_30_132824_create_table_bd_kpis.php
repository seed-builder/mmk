<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdKpis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_kpis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('femp_id')->unsigned();
            $table->integer('fyear')->comment('年份');
			$table->integer('ftype')->default(0)->comment('指标类型（0-目标拜访量,1-目标销售额）');
			$table->decimal('fjan')->default(0)->comment('一月份kpi指标');
			$table->decimal('feb')->default(0)->comment('二月份kpi指标');
			$table->decimal('fmar')->default(0)->comment('三月份kpi指标');
			$table->decimal('fapr')->default(0)->comment('四月份kpi指标');
			$table->decimal('fmay')->default(0)->comment('五月份kpi指标');
			$table->decimal('fjun')->default(0)->comment('六月份kpi指标');
			$table->decimal('fjul')->default(0)->comment('七月份kpi指标');
			$table->decimal('faug')->default(0)->comment('八月份kpi指标');
			$table->decimal('fsep')->default(0)->comment('九月份kpi指标');
			$table->decimal('foct')->default(0)->comment('十月份kpi指标');
			$table->decimal('fnov')->default(0)->comment('十一月份kpi指标');
			$table->decimal('fdec')->default(0)->comment('十二月份kpi指标');

	        $table->integer('fcreator_id')->default(0)->comment('创建人');
	        $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
	        $table->integer('fmodify_id')->default(0)->comment('修改人');
	        $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
	        $table->string('fdocument_status')->default('A')->comment('审核状态');

	        $table->foreign('femp_id')->references('id')->on('bd_employees')
		        ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bd_kpis');
    }
}
