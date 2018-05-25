<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasingPerrmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_perrmission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('采购商id');
            $table->integer('recharge_camilo')->default(1)->comment('卡密采购,0为关闭');
            $table->integer('recharge_short_directly')->default(1)->comment('短充采购，0为关闭');
            $table->integer('recharge_long_directly')->default(1)->comment('长充采购，0为关闭');
            $table->integer('pay_camilo')->default(0)->comment('卡密采购0为先款，1为后款');
            $table->integer('pay_directly')->default(1)->comment('直充采购0为先款，1为后款');
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
        Schema::dropIfExists('purchasing_perrmission');
    }
}
