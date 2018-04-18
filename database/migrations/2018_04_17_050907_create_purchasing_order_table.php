<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasingOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code',20)->comment('订单号');
            $table->integer('user_id')->comment('创建者id');
            $table->integer('price')->comment('订单金额');
            $table->string('order_type',100)->comment('订单类型');
            $table->string('oil_card_code',100)->nullable()->comment('油卡卡号');
            $table->integer('oil_card_status')->nullable()->comment('油卡状态');
            $table->string('platform',100)->comment('需求平台');
            $table->integer('order_status')->default(0)->comment('订单状态');
            $table->dateTime('pay_time')->nullable()->comment('付款时间');
            $table->integer('pay_type')->default(0)->comment('付款方式');
            $table->integer('pay_real')->default(0)->comment('实际付款');
            $table->integer('unit_price')->comment('卡单价');
            $table->integer('real_unit_price')->comment('卡实际单价');
            $table->decimal('discount', 5, 2)->comment('折扣');
            $table->integer('num')->comment('卡数量');
            $table->string('remark',255)->nullable()->comment('备注');
            $table->integer('pay_status')->default(0)->comment('付款状态');
            $table->integer('is_problem')->default(0)->comment('是否问题单');
            $table->string('problem_order_code',20)->nullable()->comment('问题订单号');
            $table->integer('is_rush')->default(0)->comment('是否加急单');
            $table->string('repair_order_code',20)->nullable()->comment('补发订单号');
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
        Schema::dropIfExists('purchasing_order');
    }
}
