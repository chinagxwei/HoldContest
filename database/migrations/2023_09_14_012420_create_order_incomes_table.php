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
        Schema::create('order_incomes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('member_id')->index()->nullable()->comment('会员ID');
            $table->string('from_order_sn',64)->index()->nullable()->comment('收益订单编号');
            $table->string('to_order_sn',64)->index()->nullable()->comment('入账订单编号');
            $table->bigInteger('amount')->unsigned()->nullable()->comment('金额（单位：分）');
            $table->string('sign',64)->nullable()->comment('签名');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('订单收益表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_incomes');
    }
};
