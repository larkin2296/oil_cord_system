<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configure', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sdirectly_price_up')->default(10000)->comment('短充金额上限');
            $table->integer('sdirectly_price_down')->default(100)->comment('短充金额下限');
            $table->integer('sdirectly_day')->default(30)->comment('短充时间上限');
            $table->decimal('camilo_recharge', 5, 2)->default(1)->comment('卡密进货折扣');
            $table->decimal('camilo_sell', 5, 2)->default(1)->comment('卡密销售折扣');
            $table->decimal('ldirectly_discount', 5, 2)->default(1)->comment('长充折扣');
            $table->decimal('sdirectly_discount_up', 5, 2)->default(1)->comment('短充折扣上限');
            $table->decimal('sdirectly_discount_down', 5, 2)->default(1)->comment('短充折扣下限');
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
        Schema::dropIfExists('configure');
    }
}
