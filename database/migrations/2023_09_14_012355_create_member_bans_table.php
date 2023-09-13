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
        Schema::create('member_bans', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('member_id')->index();
            $table->integer('started_at')->unsigned()->nullable()->comment('开始时间');
            $table->integer('ended_at')->unsigned()->nullable()->comment('结束时间');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('禁封表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_ban_logs');
    }
};
