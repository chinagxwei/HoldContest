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
        Schema::create('member_competition_logs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('from_order_sn',64)->index()->nullable()->comment('报名订单编号');
            $table->uuid('member_id')->nullable()->index();
            $table->uuid('game_room_id')->nullable()->index();
            $table->integer('team_index')->default(0)->unsigned()->nullable()->comment('分组索引');
            $table->string('order_sn',64)->index()->nullable()->comment('奖励订单编号');
            $table->tinyInteger('win')->default(0)->nullable()->comment('胜利 -5挂机送人头 -4账户不一致 -3 不上场卡比赛-2恶意占队 -1输 0未定 1赢');
            $table->integer('ranking')->default(0)->unsigned()->nullable()->comment('排名');
            $table->integer('complete_at')->unsigned()->nullable()->comment('结算时间');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('会员参与比赛表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_competition_logs');
    }
};
