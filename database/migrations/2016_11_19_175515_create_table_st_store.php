<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('st_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forg_id')->default(0)->comment('组织id');
            $table->integer('fcust_id')->default(0)->comment('客户id');;
            $table->string('fnumber')->default('')->comment('编号');;
            $table->string('ffullname')->default('')->comment('全名');;
            $table->string('fshortname')->default('')->comment('简称');;
            $table->string('fprovince')->default('')->comment('省份');;
            $table->string('fcity')->default('')->comment('城市');;
            $table->string('fcountry')->default('')->comment('区县');;
            $table->string('fstreet')->default('')->comment('街道');;
            $table->string('faddress')->default('')->comment('详细地址');;
            $table->string('fpostalcode')->default('')->comment('邮编');;
            $table->string('flongitude')->default('')->comment('经度');;
            $table->string('flatitude')->default('')->comment('纬度');;
            $table->string('fcontracts')->default('')->comment('联系人');
            $table->string('ftitle')->default('')->comment('联系人职位');
            $table->string('ftelephone')->default('')->comment('联系人电话');
            $table->string('fphone')->default('')->comment('联系人手机');
            $table->string('ffax')->default('')->comment('联系人传真');
            $table->string('femail')->default('')->comment('联系人email');
            $table->string('farea_unit')->default('')->comment('单位');
            $table->decimal('farea')->default(0)->comment('面积');
            $table->integer('fchannel')->default(0)->comment('渠道分类');
            $table->integer('flevel')->default(0)->comment('门店等级');
            $table->integer('fmode')->default(0)->comment('配送模式');
            $table->integer('ftran_cust_id')->default(0)->comment('配送商id');
            $table->integer('femp_id')->default(0)->comment('负责业务员');
            $table->string('fbusslicense')->default('')->comment('营业执照');
            $table->string('fdutyparagraphe')->default('')->comment('税号');
            $table->string('fbankaccount')->default('')->comment('开户银行');
            $table->string('faccountnum')->default('')->comment('账户');
            $table->integer('fphoto')->default(0)->comment('门店图片');
            $table->string('fremark')->default('')->comment('描述');
            $table->integer('fcreator_id')->default(0)->comment('创建人');
            $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
            $table->integer('fmodify_id')->default(0)->comment('修改人');
            $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
            $table->integer('fauditor_id')->default(0)->comment('审核人');
            $table->timestamp('faudit_date')->nullable()->comment('审核日期');
            $table->string('fdocument_status')->default('A')->comment('审核状态');
            $table->integer('fforbidder_id')->default(0)->comment('禁用人');
            $table->timestamp('fforbid_date')->nullable()->comment('禁用日期');
            $table->string('fforbid_status')->default('A')->comment('禁用状态');
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
        Schema::drop('st_stores');
    }
}
