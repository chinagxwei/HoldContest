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
        Schema::create('wechat_office_accounts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('member_id')->index()->nullable()->comment('会员ID');
            $table->string('openid',128)->index()->nullable()->comment('OPENID');
            $table->string('unionid',128)->index()->nullable()->comment('同主体唯一的用户标识');
            $table->string('nickname',128)->nullable()->comment('昵称');
            $table->tinyInteger('sex')->unsigned()->nullable()->comment('性别1男2女');
            $table->string('city',64)->nullable()->comment('城市');
            $table->string('province',64)->nullable()->comment('省份');
            $table->string('country',64)->nullable()->comment('国家');
            $table->string('headimgurl',64)->nullable()->comment('头像');
            $table->tinyInteger('subscribe')->unsigned()->default(0)->nullable()->comment('订阅 0未订阅 1已订阅');
            $table->integer('subscribe_at')->unsigned()->nullable()->comment('订阅时间');
            $table->integer('unsubscribe_at')->unsigned()->nullable()->comment('订阅取消时间');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('微信公众号会员表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_office_accounts');
    }
};
