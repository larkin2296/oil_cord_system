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
            $table->time('recon_start')->comment('对账开始时间');
            $table->time('recon_end')->comment('对账结束时间');
            $table->integer('user_id')->comment('对账采购商id');
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
