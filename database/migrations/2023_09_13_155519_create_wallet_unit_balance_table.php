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
        Schema::create('wallet_unit_balance', function (Blueprint $table) {
            $table->uuid('wallet_id')->index()->nullable()->comment('钱包ID');
            $table->integer('unit_id')->unsigned()->default(0)->comment('单位ID');
            $table->bigInteger('total_balance')->unsigned()->default(0)->nullable()->comment('总余额');
            $table->string('sign', 64)->nullable()->comment('签名');
            $table->primary(['wallet_id', 'unit_id']);
            $table->comment('钱包余额表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_unit_balance');
    }
};
