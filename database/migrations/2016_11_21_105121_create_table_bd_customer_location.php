<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdCustomerLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bd_customer_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fcontact')->default('')->comment('联系人');
            $table->string('fjob')->default('')->comment('职务');
            $table->string('foffice_phone')->default('')->comment('电话');
            $table->string('ftax')->default('')->comment('传真');
            $table->string('femail')->default('')->comment('电子邮箱');
            $table->string('flocation')->default('')->comment('业务地点');
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
        Schema::drop('bd_customer_locations');
    }
}
