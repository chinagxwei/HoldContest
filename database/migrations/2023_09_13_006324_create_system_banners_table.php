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
        Schema::create('system_banners', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('title',128)->nullable()->comment('标题');
            $table->string('url',128)->nullable()->comment('url地址');
            $table->char('relation_id',36)->nullable()->comment('关联ID');
            $table->tinyInteger('relation_type')->unsigned()->default(0)->nullable()->comment('关联类型 1协议 2活动');
            $table->tinyInteger('position')->unsigned()->default(0)->nullable()->comment('位置 1首页 2比赛列表 3比赛房间 4个人信息 5广场');
            $table->tinyInteger('show')->unsigned()->default(0)->nullable()->comment('是否显示 0不显示 1显示');
            $table->tinyInteger('sort_order')->unsigned()->default(0)->nullable()->comment('顺序');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('滚动横幅表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
};
