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
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->uuid('wallet_id')->nullable()->comment('钱包ID');
            $table->integer('order_income_config_id')->unsigned()->nullable()->comment('订单收益配置ID');
            $table->string('nickname',128)->nullable()->comment('备注');
            $table->string('remark',128)->nullable()->comment('备注');
            $table->uuid('parent_id')->index()->nullable()->comment('父会员ID');
            $table->text('belong_agent_node')->nullable()->comment('属于代理节点');
            $table->string('mobile',18)->index()->nullable()->comment('联系电话');
            $table->string('promotion_sn',32)->index()->nullable()->comment('推广序列号');
            $table->tinyInteger('develop')->unsigned()->nullable();
            $table->tinyInteger('register_type')->unsigned()->default(1)->nullable()->comment('注册状态 0平台 1App 2网页 3小程序');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('会员表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
};
