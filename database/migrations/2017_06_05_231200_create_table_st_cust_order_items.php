<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStCustOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_cust_order_items', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('fcust_order_id');
	        //$table->integer('fstock_id')->default(0)->comment('库存内码id');
	        $table->integer('fmaterial_id')->default(0)->comment('物料内码id');
	        $table->string('fsale_unit')->nullable()->comment('销售单位');
	        $table->string('fbase_unit')->nullable()->comment('基本单位');
	        $table->decimal('fqty')->default(0)->comment('订单数量');
	        $table->decimal('fbase_qty')->default(0)->comment('销售基本单位数量（瓶）(订单数量*商品表FRotio)');
	        $table->decimal('fsend_qty')->default(0)->comment('发货数量');
	        $table->decimal('fsend_base_qty')->default(0)->comment('发货基本单位数量');

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
        Schema::dropIfExists('st_cust_order_items');
    }
}
