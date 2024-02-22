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
        Schema::create('competition_rules', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title',128)->nullable()->comment('标题');
            $table->integer('game_id')->unsigned()->nullable()->index()->comment('游戏ID');
            $table->integer('participants_price')->nullable()->comment('参与价格（单位：分）');
            $table->integer('unit_id')->unsigned()->comment('单位ID');
            $table->tinyInteger('participants_number')->unsigned()->nullable()->comment('参与人数');
            $table->tinyInteger('start_number')->unsigned()->nullable()->comment('开始人数');
            $table->integer('daily_participation_limit')->unsigned()->default(0)->nullable()->comment('每日场次上限 0无限 具体数据为次数');
            $table->integer('default_start_second')->unsigned()->default(0)->nullable()->comment('默认开始秒数');
            $table->integer('default_end_second')->unsigned()->default(0)->nullable()->comment('默认结束秒数');
            $table->text('rule')->nullable()->comment('比赛规则');
            $table->text('description')->nullable()->comment('描述');
            $table->string('remark',128)->nullable()->comment('备注');
            $table->tinyInteger('team_game')->unsigned()->default(1)->nullable()->comment('是否是团队游戏 0个人对抗 1团队对抗');
            $table->tinyInteger('quick')->unsigned()->default(0)->nullable()->comment('快速游戏 0否 1是');
            $table->tinyInteger('status')->unsigned()->default(0)->nullable()->comment('状态 0启用 1停用');
            $table->tinyInteger('sort_order')->unsigned()->default(0)->nullable()->comment('顺序');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('比赛规则表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_rules');
    }
};
