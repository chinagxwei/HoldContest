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
            $table->uuid('parent_id')->index()->nullable()->comment('父ID');
            $table->string('game_name',128)->nullable()->comment('游戏名称');
            $table->text('description')->nullable()->comment('描述');
            $table->string('remark',128)->nullable()->comment('备注');
            $table->tinyInteger('sort_order')->unsigned()->default(0)->nullable()->comment('顺序');
            $table->tinyInteger('show')->unsigned()->default(0)->nullable()->comment('是否显示 0不显示 1显示');
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
