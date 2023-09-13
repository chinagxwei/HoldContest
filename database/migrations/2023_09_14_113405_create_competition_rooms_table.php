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
            $table->integer('game_id')->unsigned()->nullable()->index()->comment('游戏ID');
            $table->string('game_room_name',128)->nullable()->comment('游戏房间名称');
            $table->tinyInteger('status')->unsigned()->default(1)->nullable()->comment('比赛状态 1开始报名 2赛前准备 3比赛开始 4比赛结果审核 5比赛结束');
            $table->tinyInteger('quick')->unsigned()->default(0)->nullable()->comment('快速比赛 0否 1是');
            $table->tinyInteger('complete')->unsigned()->default(0)->nullable()->comment('完成比赛 0否 1是');
            $table->string('game_room_qrcode',128)->nullable()->comment('游戏房间二维码');
            $table->tinyInteger('interval')->unsigned()->nullable()->comment('游戏间隔');
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
