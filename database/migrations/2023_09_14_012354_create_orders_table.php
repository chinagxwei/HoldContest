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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('sn',64)->index()->nullable();
            $table->string('third_party_payment_sn',64)->nullable()->comment('第三方支付ID');
            $table->string('third_party_merchant_id',18)->nullable()->comment('第三方支付商户号');
            $table->tinyInteger('order_category')->unsigned()->default(0)->comment('订单类型 1充值订单 2VIP订单 3提款订单 4消费订单');
            $table->uuid('member_id')->index()->nullable()->comment('会员ID');
            $table->tinyInteger('pay_method')->unsigned()->default(0)->comment('支付方式 1平台 2第三方支付 3虚拟账户');
            $table->integer('unit_id')->unsigned()->default(0)->comment('单位ID');
            $table->integer('pay_at')->unsigned()->default(0)->comment('支付时间');
            $table->tinyInteger('pay_status')->default(0)->comment('支付状态 -1 取消 0 未支付 1 支付中 2 已支付');
            $table->bigInteger('total_amount')->unsigned()->nullable()->comment('订单金额（单位：分）');
            $table->bigInteger('reduce_amount')->unsigned()->nullable()->comment('减少金额（单位：分）');
            $table->bigInteger('pay_amount')->unsigned()->nullable()->comment('支付金额（单位：分）');
            $table->bigInteger('commission_amount')->unsigned()->nullable()->comment('佣金金额（单位：分）');
            $table->bigInteger('real_income_amount')->unsigned()->nullable()->comment('实际收入金额（单位：分）');
            $table->integer('cancel_at')->unsigned()->default(0)->comment('取消时间');
            $table->string('remark',128)->nullable()->comment('备注');
            $table->string('sign',64)->nullable()->comment('签名');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('订单表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
