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
        Schema::create('wallet_consumes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('order_sn',64)->index()->nullable()->comment('订单编号');
            $table->uuid('wallet_id')->index()->nullable()->comment('钱包ID');
            $table->uuid('wallet_recharge_id')->index()->nullable()->comment('充值ID');
            $table->uuid('member_id')->index()->nullable()->comment('会员ID');
            $table->bigInteger('amount')->unsigned()->nullable()->comment('金额（单位：分）');
            $table->tinyInteger('status')->unsigned()->default(1)->nullable()->comment('状态 0取消 1启用');
            $table->string('sign',64)->nullable();
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('钱包消费表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_consumes');
    }
};
