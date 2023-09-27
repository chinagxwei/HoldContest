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
        Schema::create('ad_xianwan', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('adid')->unsigned()->nullable()->comment('广告ID');
            $table->string('adname',128)->nullable()->comment('广告名称');
            $table->string('ordernum',64)->nullable()->comment('订单编号');
            $table->integer('dlevel')->unsigned()->nullable()->comment('奖励级别');
            $table->integer('atype')->unsigned()->nullable()->comment('奖励类型');
            $table->string('deviceid',64)->nullable()->comment('设备号');
            $table->string('simid',64)->nullable()->comment('开发者用户编号(会员ID)');
            $table->string('appsign',64)->nullable()->comment('用户体验游戏注册账号ID');
            $table->string('merid',64)->nullable()->comment('奖励说明');
            $table->text('event')->nullable()->comment('图片地址');
            $table->string('adicon',128)->nullable()->comment('');
            $table->decimal('price',15)->unsigned()->nullable()->comment('广告商结算单价，单位元');
            $table->decimal('money',15)->unsigned()->nullable()->comment('平台给会员奖励，单位元');
            $table->integer('itime')->unsigned()->nullable()->comment('用户获得奖励时间');
            $table->tinyInteger('status')->unsigned()->nullable()->comment('状态');
            $table->string('keycode',128)->nullable()->comment('');

            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('闲玩-广告表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_xianwan');
    }
};
