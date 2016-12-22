<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVisitPzbz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_pzbz', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fbill_no')->default('')->comment('bill no');
            $table->string('fremark')->default('')->comment('备注');
            $table->string('fphotos')->default('')->comment('图片id 集合， 逗号隔开');
            $table->integer('flog_id')->default(0)->comment('visit_todo_calendar id');
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
        Schema::dropIfExists('visit_pzbz');
    }
}
