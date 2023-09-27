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
        Schema::create('member_lucky_draws_logs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('member_id')->index();
            $table->string('order_sn',64)->index()->nullable()->comment('消费订单编号');
            $table->integer('total')->unsigned()->nullable()->comment('总数');
            $table->integer('stock')->unsigned()->nullable()->comment('库存');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('会员抽奖次数表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_lucky_draws_number');
    }
};
