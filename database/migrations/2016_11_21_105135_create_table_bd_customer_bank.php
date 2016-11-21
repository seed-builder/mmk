<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdCustomerBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bd_customer_banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fcountry')->default('')->comment('开户国家');
            $table->string('fopen_bank_name')->default('')->comment('开户银行');
            $table->string('faccount')->default('')->comment('银行账号');
            $table->string('faccount_name')->default('')->comment('账户名称');
            $table->string('fcurrency_id')->default('')->comment('币别');
            $table->integer('fis_default')->default(0)->comment('默认');
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
        Schema::drop('bd_customer_banks');
    }
}
