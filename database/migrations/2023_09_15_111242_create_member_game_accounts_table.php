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
        Schema::create('member_game_accounts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('member_id')->index();
            $table->integer('game_id')->unsigned()->nullable()->index()->comment('游戏ID');
            $table->tinyInteger('account_type')->unsigned()->nullable()->comment('账户类型 1微信 2QQ');
            $table->string('nickname',128)->nullable()->index()->comment('游戏昵称');
            $table->string('game_code',128)->nullable()->index()->comment('游戏编号');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->unique(['member_id', 'game_id', 'account_type']);
            $table->comment('游戏账户表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_game_accounts');
    }
};
