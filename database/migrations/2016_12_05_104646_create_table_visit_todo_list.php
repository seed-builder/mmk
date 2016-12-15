<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVisitTodoList extends Migration
{
    /**
     * 门店寻访项目清单
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('visit_store_todo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forg_id')->default(0)->comment('组织id');
            $table->integer('fparent_id')->default(0)->comment('父级id');
            $table->string('flag')->default(0)->comment('标识符');
            $table->string('fgroup_id')->default('')->comment('分组标识');
            $table->string('fnumber')->default('')->comment('编号');
            $table->string('fname')->default('')->comment('名称');
            $table->integer('ffunction_id')->default(0)->comment('定制功能表id');
            $table->string('ffunction_number')->default('')->comment('定制功能编号');
            $table->integer('fis_must_visit')->default(0)->comment('是否必巡');

            $table->integer('fcreator_id')->default(0)->comment('创建人');
            $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
            $table->integer('fmodify_id')->default(0)->comment('修改人');
            $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
            $table->string('fdocument_status')->default('A')->comment('审核状态');

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
        Schema::drop('visit_store_todo');
    }
}
