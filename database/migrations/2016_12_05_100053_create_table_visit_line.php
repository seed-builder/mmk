<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMsStoreLine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('visit_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forg_id')->default(0)->comment('组织id');
            $table->string('fnumber')->default('')->comment('编号');
            $table->string('fname')->default('')->comment('名称');
            $table->integer('femp_id')->default(0)->comment('员工id');
            $table->integer('fmain_emp_id')->default(0)->comment('主员工id');
            $table->integer('fchecker_id')->default(0)->comment('checker_id');
            $table->timestamp('fcheck_date')->nullable()->comment('check_date');
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
        Schema::drop('visit_line');
    }
}
