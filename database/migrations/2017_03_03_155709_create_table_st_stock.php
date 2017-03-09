<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_stocks', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('fstore_id')->default(0)->comment('门店id');
	        $table->integer('flog_id')->default(0)->comment('拜访执行明细visit_todo_calendar id');
	        $table->integer('fmaterial_id')->default(0)->comment('物料内码id');
	        $table->decimal('fhqty')->default(0)->comment('箱数量');
	        $table->decimal('feqty')->default(0)->comment('瓶数量');
	        $table->decimal('fbase_eqty')->default(0)->comment('库存基本单位数量（瓶）');
	        $table->decimal('fsale_hqty')->default(0)->comment('建议销售数量(箱)');
	        $table->decimal('fold_eqty')->default(0)->comment('上次盘点库存基本单位数量(瓶)');
	        $table->timestamp('ftime')->nullable()->comment('盘点时间');

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
        Schema::dropIfExists('st_stocks');
    }
}
