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
        Schema::create('competition_game_prizes', function (Blueprint $table) {
            $table->integer('game_id')->unsigned()->nullable()->index()->comment('游戏ID');
            $table->integer('goods_id')->unsigned()->nullable()->comment('商品ID');
            $table->tinyInteger('prize_index')->unsigned()->nullable()->comment('奖励索引');
            $table->primary(['game_id', 'goods_id']);
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
        Schema::dropIfExists('competition_game_prizes');
    }
};
