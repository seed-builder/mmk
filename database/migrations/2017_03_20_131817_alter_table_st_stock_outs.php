<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStStockOuts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('st_stock_outs', function (Blueprint $table) {
            //
	        $table->char('ftype')->nullable()->comment('出库类型: A-自动出库，B-经销出库，C-库存调整');
        });
	    Schema::table('st_stocks', function (Blueprint $table) {
		    //
		    $table->char('fcheck_type')->nullable()->comment('审核类型（A-自动审核，B-手工审核）');
		    $table->timestamp('fcheck_date')->nullable()->comment('审核日期（审核时记录日期及时间）');
		    $table->string('fchecker')->nullable()->comment('审核人（手工审核时，记录当前审核用户；自动审核时，记录为Admin）');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('st_stock_outs', function (Blueprint $table) {
            //
	        $table->dropColumn('ftype');
        });
	    Schema::table('st_stocks', function (Blueprint $table) {
		    $table->dropColumn('fcheck_type');
		    $table->dropColumn('fcheck_date');
		    $table->dropColumn('fchecker');
	    });
    }
}
