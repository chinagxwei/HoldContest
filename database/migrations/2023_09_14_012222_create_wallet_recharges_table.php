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
        Schema::create('wallet_recharges', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('order_sn',64)->index()->nullable()->comment('订单编号');
            $table->uuid('wallet_id')->index()->nullable()->comment('钱包ID');
            $table->bigInteger('denomination')->unsigned()->nullable()->comment('面额（单位：分）');
            $table->bigInteger('balance')->unsigned()->nullable()->comment('余额（单位：分）');
            $table->integer('unit_id')->unsigned()->default(0)->comment('单位ID');
            $table->tinyInteger('frozen')->unsigned()->default(0)->nullable()->comment('充值冻结 0不是 1是');
            $table->tinyInteger('channel')->unsigned()->nullable()->comment('充值渠道 1用户 2平台');
            $table->tinyInteger('gift')->unsigned()->default(0)->nullable()->comment('赠送充值 0不是 1是');
            $table->string('sign',64)->nullable()->comment('签名');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('钱包充值表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_recharges');
    }
};
