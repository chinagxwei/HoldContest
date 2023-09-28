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
        Schema::create('competition_games', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->tinyInteger('team_game')->unsigned()->nullable()->comment('是否是团队游戏 1个人对抗 2团队对抗');
            $table->string('game_name',128)->nullable()->comment('游戏名称');
            $table->tinyInteger('quick')->unsigned()->default(0)->nullable()->comment('快速游戏 0否 1是');
            $table->integer('participants_price')->nullable()->comment('参与价格（单位：分）');
            $table->tinyInteger('participants_number')->unsigned()->nullable()->comment('参与人数');
            $table->tinyInteger('start_number')->unsigned()->nullable()->comment('开始人数');
            $table->text('rule')->nullable()->comment('比赛规则');
            $table->text('description')->nullable()->comment('描述');
            $table->string('remark',128)->nullable()->comment('备注');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('比赛游戏表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_games');
    }
};
