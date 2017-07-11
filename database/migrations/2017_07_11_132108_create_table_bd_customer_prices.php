<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdCustomerPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('bd_customer_prices', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('fcust_id')->nullable()->comment('经销商id');
		    $table->integer('fstore_id')->nullable()->comment('门店id');
		    $table->integer('fmaterial_id')->comment('物料id');
		    $table->string('fspecification')->nullable()->comment('规格型号');
		    $table->string('fsale_unit')->nullable()->comment('销售单位 ');
		    $table->decimal('fprice_box')->default(0.0)->comment('单价/箱');
		    $table->decimal('fprice_bottle')->default(0.0)->comment('单价/瓶');
		    $table->integer('fmin_qty')->default(0)->comment('数量起');
		    $table->integer('fmax_qty')->default(1000000)->comment('数量止');
		    $table->timestamp('fcreate_date')->nullable();
		    $table->timestamp('fmodify_date')->nullable();
		    $table->char('fdocument_status', 1)->default('A')->comment('审核状态（A-未审核, B-审核中, C-审核通过)');
		    $table->integer('fis_valid')->default(1)->comment('是否有效(1-有效， 2-无效)');
		    $table->integer("finvalid_operator")->nullable()->comment('作废人');
		    $table->timestamp('finvalid_date')->nullable()->comment('作废日期');
	    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	    Schema::dropIfExists('bd_customer_prices');
    }
}
