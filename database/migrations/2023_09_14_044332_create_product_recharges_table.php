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
        Schema::create('product_recharges', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title', 128)->comment('标题');
            $table->bigInteger('denomination')->unsigned()->nullable()->comment('面额（单位：分）');
            $table->bigInteger('give_amount')->unsigned()->nullable()->comment('赠送金额（单位：分）');
            $table->integer('unit_id')->unsigned()->comment('单位ID');
            $table->tinyInteger('show')->unsigned()->default(0)->nullable()->comment('是否显示 0不显示 1显示');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('充值产品表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_rechargeable_cards');
    }
};
