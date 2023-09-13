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
        Schema::create('member_quests', function (Blueprint $table) {
            $table->uuid('member_id')->index()->nullable()->comment('会员ID');
            $table->integer('quest_id')->unsigned()->nullable()->index()->comment('任务ID');
            $table->integer('progress')->unsigned()->default(0)->nullable()->index()->comment('任务项完成进度值');
            $table->integer('complete')->unsigned()->default(0)->nullable()->index()->comment('是否完成 0否 1是');

            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->primary(['member_id', 'quest_id']);
            $table->comment('会员参与任务日志表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_quest_logs');
    }
};
