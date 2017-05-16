<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdPriceGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_price_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fnumber')->nullable()->comment();
            $table->string('fname')->comment('名称');
            $table->string('fsuit_object')->default('store')->comment('适用范围:(all-全部, store-门店, customer-经销商)');
            $table->timestamp('fbegin')->nullable()->comment('起始时间');
            $table->timestamp('fend')->nullable()->comment('截止时间');
            $table->integer('flevel')->default(9)->comment('优先级（数字越大优先级越低）');
            $table->char('fdocument_status', 1)->default('A')->comment('审核状态（A-未审核, B-审核中, C-审核通过)');
	        $table->timestamp('fcheck_date')->nullable()->comment('审核日期');
	        $table->timestamp('fchecker')->nullable()->comment('审核人id');
	        $table->timestamp('fcreate_date')->nullable();
	        $table->timestamp('fmodify_date')->nullable();
	        $table->integer('fcreator')->nullable();
	        $table->integer('fmodifier')->nullable();

        });

	    Schema::create('bd_prices', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('fgroup_id')->unsigned();
		    $table->integer('fmaterial_id')->unsigned();
		    $table->decimal('fprice')->default(0)->comment('价格');
		    $table->integer('fmin_qty')->default(0)->comment('数量起');
		    $table->integer('fmax_qty')->default(1000000)->comment('数量止');
		    $table->timestamp('fcreate_date')->nullable();
		    $table->timestamp('fmodify_date')->nullable();
		    $table->char('fdocument_status', 1)->default('A')->comment('审核状态（A-未审核, B-审核中, C-审核通过)');
		    $table->timestamp('fcheck_date')->nullable()->comment('审核日期');
		    $table->timestamp('fchecker')->nullable()->comment('审核人id');

		    $table->foreign('fgroup_id')->references('id')->on('bd_price_groups')
			    ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('fmaterial_id')->references('id')->on('bd_materials')
			    ->onUpdate('cascade')->onDelete('cascade');

	    });

	    Schema::create('bd_price_group_store', function (Blueprint $table) {
			$table->integer('fgroup_id')->unsigned();
			$table->integer('fstore_id')->unsigned();

		    $table->foreign('fgroup_id')->references('id')->on('bd_price_groups')
			    ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('fstore_id')->references('id')->on('st_stores')
			    ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['fgroup_id', 'fstore_id']);
	    });

	    Schema::create('bd_price_group_customer', function (Blueprint $table) {
		    $table->integer('fgroup_id')->unsigned();
		    $table->integer('fcustomer_id')->unsigned();

		    $table->foreign('fgroup_id')->references('id')->on('bd_price_groups')
			    ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('fcustomer_id')->references('id')->on('bd_customers')
			    ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['fgroup_id', 'fcustomer_id']);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('bd_price_group_customer');
	    Schema::dropIfExists('bd_price_group_store');
        Schema::dropIfExists('bd_prices');
        Schema::dropIfExists('bd_price_groups');
    }
}
