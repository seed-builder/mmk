<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFinStatement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_statements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("seq")->default(0)->comment("打印排序使用");
            $table->integer("year")->default(0)->comment("年份");
            $table->integer("month")->default(0)->comment("月份");
            $table->integer("cust_id")->default(0)->comment("经销商id");
            $table->string("cust_num")->nullable()->comment("经销商编号");
            $table->string("cust_name")->nullable()->comment("经销商名称");
            $table->string("bill_type")->nullable()->comment("单据类型");
            $table->string("bill_no")->nullable()->comment("单据编码");
            $table->string("srcbill_no")->nullable()->comment("源单编号");
            $table->string("project_no")->nullable()->comment("方案编号 ");
            $table->timestamp("bill_date")->nullable()->comment('业务日期');
            $table->decimal("cur_amount")->default(0)->comment('本期发生额');
            $table->decimal("bal_amount")->default(0)->comment('余额');
	        $table->string("abstract")->nullable()->comment("摘要");
	        $table->string("remarks")->nullable()->comment("备注");
	        $table->integer("status")->default(0)->comment('0-未对账，1-已对账 ');
	        $table->integer("print_status")->default(0)->comment('0-未打印，1-已打印 ');
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
        Schema::dropIfExists('fin_statements');
    }
}
