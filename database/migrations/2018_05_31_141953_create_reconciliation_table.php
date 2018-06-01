<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReconciliationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reconciliation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code',20)->comment('对账单号');
            $table->integer('type')->comment('类型，0为供应，1为上报');
            $table->integer('order_id')->comment('对应数据id');
            $table->integer('user_id')->comment('采购商id');
            $table->integer('status')->comment('对账单状态,1为未完成，2为已完成');
            $table->dateTime('recon_start')->comment('对账单开始');
            $table->dateTime('recon_end')->comment('对账单结束');
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
        Schema::dropIfExists('reconciliation');
    }
}
