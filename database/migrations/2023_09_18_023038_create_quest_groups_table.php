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
        Schema::create('quest_groups', function (Blueprint $table) {
            $table->integer('parent_id')->unsigned();
            $table->integer('child_id')->unsigned();
            $table->primary(['parent_id', 'child_id']);
            $table->comment('任务关系表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quest_groups');
    }
};
