<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresentForwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('present_forward', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('forward_id')->nullable()->comment('提现表id');
            $table->integer('supply_id')->nullable()->comment('卡密表id');
            $table->integer('cam_id')->nullable()->comment('订单表id');
            $table->integer('status')->nullable()->comment('状态 1-成功 2-失败');
            $table->timestamps();
            /*软删除*/
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('present_forward');
    }
}
