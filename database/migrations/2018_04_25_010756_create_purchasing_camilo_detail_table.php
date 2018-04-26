<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasingCamiloDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_camilo_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code',20)->comment('订单号');
            $table->integer('camilo_id')->comment('卡密id');
            $table->integer('is_used')->default(0)->comment('是否已使用');
            $table->integer('is_problem')->default(0)->comment('是否有问题');
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
        Schema::dropIfExists('purchasing_camilo_detail');
    }
}
