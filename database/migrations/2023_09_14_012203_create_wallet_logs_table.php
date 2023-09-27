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
        Schema::create('wallet_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('wallet_id')->index()->nullable()->comment('钱包ID');
            $table->string('order_sn',64)->index()->nullable()->comment('订单编号');
            $table->integer('unit_id')->unsigned()->default(0)->comment('单位ID');
            $table->bigInteger('amount')->nullable()->comment('金额（单位：分），正数入账，负数出账');
            $table->bigInteger('surplus')->unsigned()->nullable()->comment('盈余（单位：分）');
            $table->tinyInteger('type')->unsigned()->nullable()->comment('流水类型 1 出账 2 入账');
            $table->string('sign',64)->nullable()->comment('签名');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('钱包流水日志表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_logs');
    }
};
