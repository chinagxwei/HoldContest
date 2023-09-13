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
        Schema::create('lucky_draws_items', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title',128)->nullable()->comment('标题');
            $table->string('image',128)->nullable()->comment('图片');
            $table->integer('goods_id')->unsigned()->index()->nullable()->comment('商品ID');
            $table->tinyInteger('status')->unsigned()->default(1)->index()->nullable()->comment('状态 0启用 1停用');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('抽奖项表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lucky_draws_items');
    }
};
