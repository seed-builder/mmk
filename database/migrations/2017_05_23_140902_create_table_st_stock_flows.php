<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStStockFlows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_stock_flows', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('fstore_id')->default(0)->comment('门店ID');
	        $table->integer('fmaterial_id')->default(0)->comment('物料内码id');
	        $table->decimal('fqty')->default(0)->comment('销售单位数量');
	        $table->decimal('fbase_qty')->default(0)->comment('销售基本单位数量（瓶）(订单数量*商品表FRotio)');
	        $table->integer('ftype')->default(0)->comment('类型(0-入库，1-出库)');

	        $table->integer('fcreator_id')->default(0)->comment('创建人');
	        $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
	        $table->integer('fmodify_id')->default(0)->comment('修改人');
	        $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
	        $table->string('fdocument_status')->default('C')->comment('审核状态');
        });

        Schema::table('st_stocks', function (Blueprint $table) {
	        $table->decimal('fqty')->default(0)->comment('销售单位数量');
	        $table->decimal('fbase_qty')->default(0)->comment('销售基本单位数量（瓶）(订单数量*商品表FRotio)');
        });

	    Schema::table('st_sale_order_items', function (Blueprint $table) {
		    $table->decimal('box_qty')->default(0)->comment('原始输入-箱数量');
		    $table->decimal('bottle_qty')->default(0)->comment('原始输入-瓶数量');
		    $table->decimal('present_box_qty')->default(0)->comment('原始输入-赠送的箱数量');
		    $table->decimal('present_bottle_qty')->default(0)->comment('原始输入-赠送的瓶数量');
	    });

	    Schema::table('cust_stock_in_items', function (Blueprint $table) {
		    $table->decimal('box_qty')->default(0)->comment('原始输入-箱数量');
		    $table->decimal('bottle_qty')->default(0)->comment('原始输入-瓶数量');
	    });

	    Schema::table('cust_stock_out_items', function (Blueprint $table) {
		    $table->decimal('box_qty')->default(0)->comment('原始输入-箱数量');
		    $table->decimal('bottle_qty')->default(0)->comment('原始输入-瓶数量');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('st_stock_flows');
	    Schema::table('st_stocks', function (Blueprint $table) {
		    $table->dropColumn('fqty');
		    $table->dropColumn('fbase_qty');
	    });
	    Schema::table('st_sale_order_items', function (Blueprint $table) {
		    $table->dropColumn('box_qty');
		    $table->dropColumn('bottle_qty');
		    $table->dropColumn('present_box_qty');
		    $table->dropColumn('present_bottle_qty');
	    });

	    Schema::table('cust_stock_in_items', function (Blueprint $table) {
		    $table->dropColumn('box_qty');
		    $table->dropColumn('bottle_qty');
	    });

	    Schema::table('cust_stock_out_items', function (Blueprint $table) {
		    $table->dropColumn('box_qty');
		    $table->dropColumn('bottle_qty');
	    });
    }
}
