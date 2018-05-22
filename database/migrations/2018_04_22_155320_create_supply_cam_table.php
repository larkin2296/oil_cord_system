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
            $table->integer('denomination')->nullable()->comment('卡密面额');
            $table->integer('platform_id')->nullable()->comment('平台id');
            $table->text('remark')->nullable()->comment('问题描述');
            $table->string('cam_name',200)->nullable()->comment('卡密名称');
            $table->integer('status')->default(1)->comment('状态,1上传成功,2下发采购商,3问题卡密,4销卡成功');
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
        Schema::dropIfExists('supply_cam');
    }
}
