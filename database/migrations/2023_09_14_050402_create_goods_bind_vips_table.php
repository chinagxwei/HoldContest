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
        Schema::create('goods_bind_vips', function (Blueprint $table) {
            $table->uuid('goods_id');
            $table->integer('vip_id')->unsigned();
            $table->primary(['goods_id', 'vip_id']);
            $table->comment('商品绑定VIP表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_bind_vips');
    }
};
