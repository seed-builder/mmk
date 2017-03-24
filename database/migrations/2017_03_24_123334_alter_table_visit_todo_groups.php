<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVisitTodoGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visit_todo_groups', function (Blueprint $table) {
            //
	        $table->integer('fis_default')->default(0)->comment('是否默认分组方案');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visit_todo_groups', function (Blueprint $table) {
            //
	        $table->dropColumn('fis_default');
        });
    }
}
