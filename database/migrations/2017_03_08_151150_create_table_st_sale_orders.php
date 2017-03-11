<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStSaleOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_sale_orders', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('fstore_id')->default(0)->comment('门店id');
	        //$table->integer('flog_id')->default(0)->comment('拜访执行明细visit_todo_calendar id');
	        $table->string('fbill_no')->default('')->comment('订单单号(门店编码+日期)');
	        $table->timestamp('fdate')->nullable()->comment('下单日期');
	        $table->integer('femp_id')->default(0)->comment('业务员id');
	        $table->integer('fcust_id')->default(0)->comment('经销商ID');
	        $table->char('fsend_status', 1)->default('A')->comment('发货状态(A-未发货，B-发货中，C-已到货)');

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
        Schema::dropIfExists('st_sale_orders');
    }
}
