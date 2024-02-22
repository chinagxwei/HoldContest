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
        Schema::create('member_addresses', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('member_id');
            $table->tinyInteger('default')->unsigned()->default(0)->nullable()->comment('默认使用 0否 1是');
            $table->string('contact',64)->nullable()->comment('联系人');
            $table->string('mobile',18)->nullable()->comment('联系电话');
            $table->string('province_name',128)->nullable()->comment('省份');
            $table->string('city_name',128)->nullable()->comment('城市');
            $table->string('county_name',128)->nullable()->comment('县份');
            $table->string('street_name',128)->nullable()->comment('街道');
            $table->string('detail_info',255)->nullable()->comment('详细地址');
            $table->integer('created_at')->unsigned()->nullable();
            $table->integer('updated_at')->unsigned()->nullable();
            $table->integer('created_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('updated_by')->index()->unsigned()->nullable()->comment('用户ID');
            $table->integer('deleted_at')->unsigned()->nullable();
            $table->comment('会员地址表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_addresses');
    }
};
