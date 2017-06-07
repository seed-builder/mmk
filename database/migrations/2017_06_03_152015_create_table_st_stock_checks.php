<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStStockChecks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_stock_checks', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer("fcust_id");
	        $table->integer("fcust_user_id");
	        $table->timestamp("fcheck_date")->nullable()->comment('盘点日期');
	        $table->integer("fcheck_status")->default(0)->comment('0-盘点中,1-盘点完成，2-取消盘点');
	        $table->integer("fchecker_id")->nullable()->comment('盘点人id(user id)');
	        $table->timestamp('fcreate_date')->nullable();
	        $table->timestamp('fmodify_date')->nullable();
        });

	    Schema::create('st_stock_check_items', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer("fstock_check_id");
		    $table->integer("fmaterial_id");
		    $table->decimal('finv_hqty')->default(0)->comment('（合计）期初库存余额箱数量（余额表取值）');
		    $table->decimal('finv_eqty')->default(0)->comment('（合计）期初库存余额瓶数量（余额表取值）');
		    $table->decimal('fcheck_hqty')->default(0)->comment('（合计）盘点箱数量');
		    $table->decimal('fcheck_eqty')->default(0)->comment('（合计）盘点瓶数量');
		    $table->decimal('fdiff_hqty')->default(0)->comment('（合计）盘点差异箱数量(库存减盘点)');
		    $table->decimal('fdiff_eqty')->default(0)->comment('（合计）盘点差异瓶数量(库存减盘点)');

		    $table->integer('box_qty')->default(0)->comment('（拆分）盘点箱数量');
		    $table->integer('bottle_qty')->default(0)->comment('（拆分）盘点瓶数量');

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
        Schema::dropIfExists('st_stock_checks');
        Schema::dropIfExists('st_stock_check_items');
    }
}
