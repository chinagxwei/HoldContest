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
        Schema::create('admin_message_logs', function (Blueprint $table) {
            $table->integer('message_id')->unsigned();
            $table->integer('admin_id')->unsigned();
            $table->primary(['message_id', 'admin_id']);
            $table->comment('管理员平台消息阅读表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_message_logs');
    }
};
