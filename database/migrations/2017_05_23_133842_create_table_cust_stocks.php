<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCustStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_stocks', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('fcust_id')->default(0)->comment('经销商id');
	        $table->integer('fmaterial_id')->default(0)->comment('物料内码id');
	        $table->decimal('fqty')->default(0)->comment('销售单位(箱)数量');
	        $table->decimal('fbase_qty')->default(0)->comment('销售基本单位(瓶)数量');
	        $table->decimal('box_qty')->default(0)->comment('原始输入-箱数量');
	        $table->decimal('bottle_qty')->default(0)->comment('原始输入-瓶数量');
	        $table->integer('fcreator_id')->default(0)->comment('创建人');
	        $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
	        $table->integer('fmodify_id')->default(0)->comment('修改人');
	        $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
	        $table->string('fdocument_status')->default('C')->comment('审核状态');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cust_stocks');
    }
}
