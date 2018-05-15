<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forward', function (Blueprint $table) {
            $table->increments('id');
            $table->string('forward_number')->nullable()->comment('提现单号');
            $table->string('money')->nullable()->comment('金额');
            $table->integer('status')->nullable()->comment('状态 1-未到账 2-已到账');
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
        Schema::dropIfExists('forward');
    }
}
