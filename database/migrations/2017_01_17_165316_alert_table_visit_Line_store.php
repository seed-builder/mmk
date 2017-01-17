<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableVisitLineStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visit_line_store', function (Blueprint $table) {
            //
	        $table->integer('femp_id')->default(0)->comment('employee id');
	        $table->integer('fweek_day')->default(0)->comment('week day');

	        $table->integer('fcreator_id')->default(0)->comment('创建人');
	        $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
	        $table->integer('fmodify_id')->default(0)->comment('修改人');
	        $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
	        $table->string('fdocument_status')->default('A')->comment('数据状态');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visit_line_store', function (Blueprint $table) {
            //
	        $table->dropColumn('femp_id');
	        $table->dropColumn('fweek_day');
	        $table->dropColumn('fcreator_id');
	        $table->dropColumn('fcreate_date');
	        $table->dropColumn('fmodify_id');
	        $table->dropColumn('fmodify_date');
	        $table->dropColumn('fdocument_status');
        });
    }
}
