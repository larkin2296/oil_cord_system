<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresentSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('present_setting', function (Blueprint $table) {
            $table->increments('id');

            $table->string('upper_money',40)->nullable()->comment('上限金额');
            $table->string('lower_money',50)->nullable()->comment('下限金额');
            $table->string('deductions',50)->nullable()->comment('扣费金额');
            $table->string('greater_money',50)->nullable()->comment('扣费开始金额');
            $table->string('proportion',50)->nullable()->comment('扣费利率');

            $table->integer('status')->nullable()->comment('状态 1-开启 2-关闭');
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
        Schema::dropIfExists('present_setting');
    }
}
