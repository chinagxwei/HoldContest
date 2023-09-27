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
        Schema::create('goods', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('title', 128)->comment('标题');
            $table->string('description', 128)->comment('标题');
            $table->bigInteger('stock')->unsigned()->nullable()->comment('库存');
            $table->tinyInteger('status')->unsigned()->default(0)->nullable()->comment('状态 0 关闭 1 开启');
            $table->tinyInteger('bind')->unsigned()->default(0)->nullable()->comment('关联到其他业务 0不允许 1允许');
            $table->integer('started_at')->unsigned()->nullable()->comment('开始时间');
            $table->integer('ended_at')->unsigned()->nullable()->comment('结束时间');
            $table->integer('sort')->unsigned()->nullable()->comment('排序');
            $table->string('remark',128)->nullable()->comment('备注');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('商品表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
};
