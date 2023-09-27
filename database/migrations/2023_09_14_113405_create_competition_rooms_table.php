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
        Schema::create('competition_rooms', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->integer('competition_rule_id')->unsigned()->nullable()->index()->comment('游戏规则ID');
            $table->string('game_room_name',128)->nullable()->comment('游戏房间名称');
            $table->string('game_room_code',128)->unique()->nullable()->comment('游戏房间编号');
            $table->integer('game_room_pwd')->unsigned()->nullable()->comment('游戏房间密码');
            $table->tinyInteger('status')->default(1)->nullable()->comment('比赛状态 -1取消 1比赛开始 2比赛结果审核 3比赛结束');
            $table->tinyInteger('quick')->unsigned()->default(0)->nullable()->comment('快速比赛 0否 1是');
            $table->tinyInteger('complete')->unsigned()->default(0)->nullable()->comment('完成比赛 0否 1是');
            $table->tinyInteger('interval')->unsigned()->nullable()->comment('游戏间隔');
            $table->string('link',128)->nullable()->comment('房间链接');
            $table->string('link_hash',64)->unique()->index()->nullable()->comment('链接哈希码');
            $table->integer('ready_at')->unsigned()->nullable()->comment('准备时间');
            $table->integer('started_at')->unsigned()->nullable()->comment('开始时间');
            $table->integer('ended_at')->unsigned()->nullable()->comment('结束时间');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('比赛房间表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_rooms');
    }
};
