<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title',128)->nullable()->comment('标题');
            $table->string('description',128)->nullable()->comment('描述');
            $table->integer('started_at')->unsigned()->nullable()->comment('开始时间');
            $table->integer('ended_at')->unsigned()->nullable()->comment('结束时间');
            $table->tinyInteger('status')->unsigned()->default(0)->nullable()->comment('状态 0启用 1停用');
            $table->tinyInteger('auto_start')->unsigned()->default(0)->nullable()->comment('自动开始 0否 1是');
            $table->integer('participate_count')->unsigned()->default(0)->nullable()->comment('参与次数 0不限 大于零为限定次数');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('任务表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quests');
    }
};
