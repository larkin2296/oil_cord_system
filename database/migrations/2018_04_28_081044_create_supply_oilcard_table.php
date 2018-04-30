<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplyOilcardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_oilcard', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->comment('供应商id');
            $table->integer('oil_id')->comment('油卡id');

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
        Schema::dropIfExists('supply_oilcard');
    }
}
