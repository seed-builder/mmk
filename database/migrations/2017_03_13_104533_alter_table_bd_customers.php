<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBdCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('bd_customers', function (Blueprint $table) {
		    //
		    //$table->dropColumn('fservice_depart');
		    $table->integer('fservice_depart')->default(0)->comment('所属服务处(bd_department id)')->change();
		    $table->string('password')->nullable()->comment('密码');
		    $table->string('login_name')->nullable()->comment('登陆名称');
		    $table->string('remember_token')->nullable()->comment('remember_token');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	    Schema::table('bd_customers', function (Blueprint $table) {
		    //
		    //$table->dropColumn('fservice_depart');
		    $table->dropColumn('password');
		    $table->dropColumn('login_name');
		    $table->dropColumn('remember_token');
	    });
    }
}
