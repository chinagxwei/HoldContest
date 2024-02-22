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
        Schema::create('app_publish_logs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title',128)->nullable()->comment('标题');
            $table->text('content')->nullable()->comment('内容');
            $table->tinyInteger('device')->unsigned()->nullable()->comment('app类型 1安卓 2苹果');
            $table->tinyInteger('update_method')->unsigned()->default(0)->nullable()->comment('更新方式 0非强制更新 1强制更新');
            $table->string('app_version',64)->nullable()->comment('版本');
            $table->integer('app_version_code')->unsigned()->nullable()->comment('版本号');
            $table->string('download_url',128)->nullable()->comment('下载地址');

            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('app发布表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_update_logs');
    }
};
