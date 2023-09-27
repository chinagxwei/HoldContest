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
        Schema::create('wallet_withdraw_accounts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('member_id')->index();
            $table->tinyInteger('account_type')->unsigned()->default(1)->nullable()->comment('账户类型 1支付宝 2银行卡');
            $table->string('contact',64)->nullable()->comment('联系人');
            $table->string('mobile',18)->index()->nullable()->comment('联系电话');
            $table->string('account',128)->nullable()->comment('账户');
            $table->string('bank_name',128)->nullable()->comment('银行名称');
            $table->string('sign',64)->nullable()->comment('签名');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('提现账户表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_withdraw_accounts');
    }
};
