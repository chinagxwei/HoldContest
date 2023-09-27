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
        Schema::create('system_complaints', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('title',128)->nullable()->comment('标题');
            $table->text('content')->nullable()->comment('内容');
            $table->tinyInteger('type')->default(0)->nullable()->comment('类型');
            $table->tinyInteger('status')->default(0)->nullable()->comment('状态 0 未处理 1 已处理');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('系统投诉表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_complaints');
    }
};
