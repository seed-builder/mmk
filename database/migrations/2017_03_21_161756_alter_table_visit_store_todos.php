<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVisitStoreTodos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visit_store_todo', function (Blueprint $table) {
            //
	        $table->integer('fstore_id')->default(0)->comment('store id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visit_store_todo', function (Blueprint $table) {
            //
	        $table->dropColumn('fstore_id');
        });
    }
}
