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
        Schema::create('member_message_logs', function (Blueprint $table) {
            $table->uuid('member_id');
            $table->integer('member_message_id')->unsigned();
            $table->primary(['member_id', 'member_message_id']);
            $table->comment('会员消息阅读日志表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_message_logs');
    }
};
