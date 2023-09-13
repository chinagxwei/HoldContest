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
        Schema::create('goods_targets', function (Blueprint $table) {
            $table->integer('goods_id')->unsigned();
            $table->integer('target_id')->unsigned();
            $table->primary(['goods_id', 'target_id']);
            $table->comment('商品标签关系表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_targets');
    }
};
