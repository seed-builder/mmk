<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdCustomerContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_customer_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname')->default('')->comment('地点名称');
            $table->string('faddress')->default('')->comment('详细地址');
            $table->string('fcontact')->default('')->comment('联系人');
            $table->string('fmobile')->default('')->comment('联系电话');
            $table->string('femail')->default('')->comment('电子邮箱');
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
        Schema::drop('bd_customer_contacts');
    }
}
