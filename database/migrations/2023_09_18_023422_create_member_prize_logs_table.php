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
        Schema::create('member_prize_logs', function (Blueprint $table) {
            $table->string('order_sn',64)->index()->nullable()->comment('订单编号');
            $table->uuid('member_id')->index()->nullable()->comment('会员ID');
            $table->tinyInteger('prize_type')->unsigned()->nullable()->comment('奖励类型 1红包 2抽奖');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->primary(['order_sn', 'member_id']);
            $table->comment('会员奖励日志表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_prizes');
    }
};
