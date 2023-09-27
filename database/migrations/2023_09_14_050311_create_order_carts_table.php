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
        Schema::create('order_carts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('order_sn',64)->index()->nullable()->comment('订单编号');
            $table->uuid('member_id')->index()->nullable()->comment('会员ID');
            $table->uuid('goods_id')->index()->nullable()->comment('商品ID');
            $table->integer('purchase_volume')->unsigned()->nullable()->comment('购买量');
            $table->string('remark',128)->nullable()->comment('备注');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('商品购物车表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_carts');
    }
};
