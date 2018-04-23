<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplySingleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_single', function (Blueprint $table) {
            $table->increments('id');
            $table->string('commodity_name',50)->nullable()->comment('商品名称');
            $table->string('denomination',20)->nullable()->comment('面额');
            $table->tinyInteger('supply_state')->nullable()->default(1)->comment('供货状态');
            $table->tinyInteger('user_id')->nullable()->comment('用户id');
            $table->string('oil_card', 30)->nullable()->comment('油卡号');
            $table->string('start_time')->nullable()->comment('供货开始时间');
            $table->text('notes')->nullable()->comment('备注');
            $table->string('end_time')->nullable()->comment('供货结束时间');
            $table->string('supply_single_number', 40)->nullable()->comment('供应单号');
            $table->string('already_card', 40)->nullable()->comment('实际销卡面额');
            $table->string('remarks', 30)->nullable()->comment('实际销卡');
            $table->string('direct_id')->nullable()->comment('直充文件id');
            $table->string('status', 30)->nullable()->comment('1-卡密供货2-直充供货');
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
        Schema::dropIfExists('supply_single');
    }
}
