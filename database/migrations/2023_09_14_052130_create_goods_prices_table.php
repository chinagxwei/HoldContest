<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_prices', function (Blueprint $table) {
            $table->uuid('goods_id');
            $table->integer('unit_id')->unsigned()->nullable()->comment('单位ID');
            $table->string('title', 128)->comment('标题');
            $table->bigInteger('price')->unsigned()->nullable()->comment('价格（单位：分）');
            $table->bigInteger('promotion_price')->unsigned()->nullable()->comment('促销价格（单位：分）');
            $table->primary(['goods_id', 'unit_id', 'price']);
            $table->comment('商品价格表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_prices');
    }
};
