<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStoreChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('st_store_changes', function (Blueprint $table) {
            //
	        $table->string('change_reason')->nullable()->comment('变更原因');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('st_store_changes', function (Blueprint $table) {
            //
	        $table->dropColumn('change_reason');
        });
    }
}
