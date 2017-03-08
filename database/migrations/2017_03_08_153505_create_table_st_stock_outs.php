<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStStockOuts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_stock_outs', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('fstore_id')->default(0)->comment('门店id');
	        $table->string('fbill_no')->default('')->comment('出库单号(门店编码+日期)');
	        $table->timestamp('fdate')->nullable()->comment('出库日期');
	        $table->timestamp('frec_date')->nullable()->comment('到货确认日期');
	        $table->timestamp('fneed_rec_date')->nullable()->comment('预计到货日期');
	        $table->string('fsbill_no')->default('')->comment('来源单号');
	        $table->integer('fuser_id')->default(0)->comment('到货确认人id');
	        $table->integer('fcust_id')->default(0)->comment('经销商ID');
	        $table->integer('frec_status')->default(0)->comment('到货状态(0未到货 1已到货)');

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
        Schema::dropIfExists('st_stock_outs');
    }
}
