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
        Schema::create('member_agents', function (Blueprint $table) {
            $table->uuid('parent_id');
            $table->uuid('child_id');
            $table->primary(['parent_id', 'child_id']);
            $table->comment('会员代理关系表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_agents');
    }
};
