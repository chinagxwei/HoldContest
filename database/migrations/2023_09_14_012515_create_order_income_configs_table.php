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
        Schema::create('order_income_configs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title', 128)->comment('标题');
            $table->decimal('vip_commission',10)->unsigned()->nullable()->comment('VIP佣金');
            $table->decimal('recharge_commission',10)->unsigned()->nullable()->comment('充值佣金');
            $table->decimal('consume_commission',10)->unsigned()->nullable()->comment('消费佣金');
            $table->decimal('level_1_play_commission',10)->unsigned()->nullable()->comment('比赛1级奖励佣金');
            $table->decimal('level_2_play_commission',10)->unsigned()->nullable()->comment('比赛2级奖励佣金');
            $table->decimal('agent_commission',10)->unsigned()->nullable()->comment('代理佣金');
            $table->decimal('withdraw_point',10)->unsigned()->nullable()->comment('提现费率');
            $table->decimal('vip_withdraw_point',10)->unsigned()->nullable()->comment('VIP提现费率');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('订单收益配置表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_income_configs');
    }
};
