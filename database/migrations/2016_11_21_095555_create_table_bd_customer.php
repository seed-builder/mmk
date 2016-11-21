<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBdCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bd_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname')->default('')->comment('客户名称');
            $table->string('fgroup')->default('0')->comment('客户分组');
            $table->string('fshort_name')->default('')->comment('客户简称');
            $table->string('fcountry')->default('')->comment('国家');
            $table->string('fprovince')->default('')->comment('省份');
            $table->string('fcity')->default('')->comment('城市');
            $table->string('farea')->default('')->comment('地区');
            $table->string('faddress')->default('')->comment('通讯地址');
            $table->string('fzip')->default('')->comment('邮政编码');
            $table->string('fwebsite')->default('')->comment('公司网址');
            $table->string('ftel')->default('')->comment('联系电话');
            $table->string('ffax')->default('')->comment('传真');
            $table->string('fsale_depart')->default('')->comment('所属营业部');
            $table->string('fservice_depart')->default('')->comment('所属服务处');
            $table->string('fseller')->default('')->comment('销售员');
            $table->string('ftax_register_code')->default('')->comment('纳税登记号');
            $table->string('fcust_type_id')->default('')->comment('客户类别');
            $table->string('fcompany_nature')->default('')->comment('公司性质');
            $table->string('fcompany_scale')->default('')->comment('公司规模');
            $table->string('ftrading_curr_id')->default('')->comment('结算币别');
            $table->string('fprice_list_id')->default('')->comment('价目表');
            $table->string('fdiscount_list_id')->default('')->comment('折扣表');
            $table->string('ftax_type')->default('')->comment('税分类');
            $table->string('finvoice_type')->default('')->comment('发票类型');
            $table->string('ftax_rate')->default('')->comment('默认税率');
            $table->integer('fis_credit_check')->default(0)->comment('启用信用管理');
            $table->string('fmode_transport')->default('')->comment('运输方式');
            $table->string('fbusiness_mode')->default('')->comment('经营模式');

            $table->integer('fcreator_id')->default(0)->comment('创建人');
            $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
            $table->integer('fmodify_id')->default(0)->comment('修改人');
            $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
            $table->integer('fauditor_id')->default(0)->comment('审核人');
            $table->timestamp('faudit_date')->nullable()->comment('审核日期');
            $table->integer('fdocument_status')->default(0)->comment('审核状态');
            $table->integer('fforbidder_id')->default(0)->comment('禁用人');
            $table->timestamp('fforbid_date')->nullable()->comment('禁用日期');
            $table->integer('fforbid_status')->default(0)->comment('禁用状态');

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
        Schema::drop('bd_customers');
    }
}
