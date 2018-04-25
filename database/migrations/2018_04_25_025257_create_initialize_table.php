<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitializeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initialize', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('上报用户');
            $table->integer('in_price')->comment('上报金额');
            $table->string('card_code',100)->comment('上报卡号');
            $table->time('in_time')->comment('上报时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('initialize');
    }
}
