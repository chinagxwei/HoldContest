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
            $table->uuid('member_id');
            $table->uuid('game_room_id');
            $table->string('order_sn',64)->index()->nullable()->comment('奖励订单编号');
            $table->tinyInteger('win')->default(0)->nullable()->comment('胜利 -1输 0未定 1赢');
            $table->integer('ranking')->default(0)->unsigned()->nullable()->comment('排名');
            $table->integer('complete_at')->unsigned()->nullable()->comment('结算时间');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->primary(['member_id', 'game_room_id']);
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
