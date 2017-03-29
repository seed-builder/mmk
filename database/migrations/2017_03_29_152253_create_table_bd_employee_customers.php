<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdEmployeeCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_employee_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('femp_id')->unsigned();
            $table->integer('fcust_id')->unsigned();
            $table->integer('fdefault')->default(0);

	        $table->foreign('femp_id')->references('id')->on('bd_employees')
		        ->onUpdate('cascade')->onDelete('cascade');
	        $table->foreign('fcust_id')->references('id')->on('bd_customers')
		        ->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bd_employee_customers');
    }
}
