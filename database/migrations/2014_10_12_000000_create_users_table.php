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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('username',128)->comment('用户名');
            $table->string('email',128)->comment('邮箱')->unique();
            $table->timestamp('email_verified_at')->comment('邮箱验证时间')->nullable();
            $table->string('password',128)->comment('密码');
            $table->rememberToken();
            $table->smallInteger('user_type')
                ->unsigned()
                ->default(5)
                ->comment('用户类型 1一般用户 100平台管理员');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('用户表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
