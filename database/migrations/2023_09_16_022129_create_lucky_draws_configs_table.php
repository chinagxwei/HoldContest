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
        Schema::create('lucky_draws_configs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title',128)->nullable()->comment('标题');
            $table->integer('total')->unsigned()->nullable()->comment('总数');
            $table->tinyInteger('status')->unsigned()->default(0)->nullable()->comment('状态 0启用 1停用');
            $table->integer('started_at')->unsigned()->nullable()->comment('开始时间');
            $table->integer('ended_at')->unsigned()->nullable()->comment('结束时间');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('抽奖次数表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lucky_draws_configs');
    }
};
