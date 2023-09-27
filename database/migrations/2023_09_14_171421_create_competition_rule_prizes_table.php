<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_rule_prizes', function (Blueprint $table) {
            $table->integer('competition_rule_id')->unsigned()->nullable()->index()->comment('比赛规则ID');
            $table->tinyInteger('ranking')->unsigned()->nullable()->comment('排名');
            $table->uuid('goods_id')->nullable()->index()->comment('商品ID');
            $table->primary(['competition_rule_id', 'ranking'],'key_index');
            $table->comment('比赛游戏奖励配置表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_rule_prize');
    }
};
