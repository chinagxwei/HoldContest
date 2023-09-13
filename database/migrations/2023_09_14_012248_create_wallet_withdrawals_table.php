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
        Schema::create('wallet_withdrawals', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('wallet_id')->index()->nullable()->comment('钱包ID');
            $table->string('order_sn',64)->index()->nullable()->comment('订单编号');
            $table->string('third_party_payment_sn',64)->nullable()->comment('第三方支付ID');
            $table->string('third_party_merchant_id',18)->nullable()->comment('第三方支付商户号');
            $table->bigInteger('amount')->unsigned()->nullable()->comment('金额（单位：分）');
            $table->string('sign',64)->nullable()->comment('签名');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('钱包提款表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_withdrawals');
    }
};
