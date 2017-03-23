<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVisitTodoGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_todo_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname')->default('')->comment('名称');
            $table->string('fremark')->default('')->comment('备注');
	        $table->timestamp('fstart_date')->nullable()->comment('有效期开始日期');
	        $table->timestamp('fend_date')->nullable()->comment('有效期截止日期');

	        $table->integer('fcreator_id')->default(0)->comment('创建人');
	        $table->timestamp('fcreate_date')->nullable()->comment('创建时间');
	        $table->integer('fmodify_id')->default(0)->comment('修改人');
	        $table->timestamp('fmodify_date')->nullable()->comment('修改时间');
	        $table->string('fdocument_status')->default('A')->comment('审核状态');
        });

	    Schema::create('visit_todo_group_details', function (Blueprint $table) {
		    $table->integer('fgroup_id')->unsigned();
		    $table->integer('fstore_todo_id')->unsigned();

		    $table->foreign('fgroup_id')->references('id')->on('visit_todo_groups')
			    ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('fstore_todo_id')->references('id')->on('visit_store_todo')
			    ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['fgroup_id', 'fstore_todo_id']);

	    });

	    Schema::create('visit_todo_group_stores', function (Blueprint $table) {
		    $table->integer('fgroup_id')->unsigned();
		    $table->integer('fstore_id')->unsigned();

		    $table->foreign('fgroup_id')->references('id')->on('visit_todo_groups')
			    ->onUpdate('cascade')->onDelete('cascade');
		    $table->foreign('fstore_id')->references('id')->on('st_stores')
			    ->onUpdate('cascade')->onDelete('cascade');

		    $table->primary(['fgroup_id', 'fstore_id']);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('visit_todo_group_details');
	    Schema::dropIfExists('visit_todo_group_stores');
        Schema::dropIfExists('visit_todo_groups');
    }
}
