<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOilSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oil_supply', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->comment('供应商Id');
            $table->integer('oil_id')->nullable()->comment('油卡Id');
            $table->integer('status')->nullable()->comment('状态 1-正常 2-禁用');

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
        Schema::dropIfExists('oil_supply');
    }
}
