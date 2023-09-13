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
        Schema::create('app_bug_logs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->text('content')->nullable()->comment('错误内容');
            $table->tinyInteger('device')->unsigned()->nullable()->comment('app类型 1安卓 2苹果');
            $table->string('app_version',64)->nullable()->comment('版本');
            $table->integer('app_version_code')->unsigned()->nullable()->comment('版本号');

            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('错误收集表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_bug_logs');
    }
};
