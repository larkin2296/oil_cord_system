<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOilCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_oil_card', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->string('serial_number',100)->nullable()->comment('油卡编号');
            $table->string('oil_card_code',100)->comment('油卡卡号');
            $table->string('identity_card',100)->comment('油卡对应的身份证');
            $table->string('ture_name',20)->comment('油卡对应的姓名');
            $table->string('web_account',100)->nullable()->comment('官网油卡账号');
            $table->string('web_password',100)->nullable()->comment('官网油卡密码');
            $table->integer('card_status')->default(1)->comment('油卡状态');
            $table->integer('is_longtrem')->default(0)->comment('是否长期充值');
            $table->integer('recharge_num')->default(0)->comment('油卡被充值总次数');
            $table->integer('recharge_today_num')->default(0)->comment('油卡今日被充值次数');
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
        Schema::dropIfExists('user_oil_card');
    }
}
