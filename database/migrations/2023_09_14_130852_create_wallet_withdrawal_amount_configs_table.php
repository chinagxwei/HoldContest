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
        Schema::create('wallet_withdrawal_amount_configs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title', 128)->comment('标题');
            $table->bigInteger('amount')->unsigned()->nullable()->comment('提款金额（单位：分）');
            $table->bigInteger('vip_amount')->unsigned()->nullable()->comment('vip提款金额（单位：分）');
            $table->integer('unit_id')->unsigned()->comment('单位ID');
            $table->tinyInteger('show')->unsigned()->default(0)->nullable()->comment('是否显示 0不显示 1显示');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('提款金额配置表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_withdrawal_amounts');
    }
};
