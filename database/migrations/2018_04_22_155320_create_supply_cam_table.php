<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplyCamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_cam', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supply_id')->nullable()->comment('供应单表id');
            $table->string('cam_name',200)->nullable()->comment('卡密名称');
            $table->string('status')->nullable()->comment('状态');
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
        Schema::dropIfExists('supply_cam');
    }
}
