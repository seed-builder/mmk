<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_attendances', function (Blueprint $table) {
            //
	        $table->string('fdept_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_attendances', function (Blueprint $table) {
            //
	        $table->dropColumn('fdept_id');
        });
    }
}
