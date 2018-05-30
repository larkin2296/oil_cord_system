<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminJurisdictionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_jurisdiction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->comment('用户id');
            $table->integer('supply_jurisdiction')->nullable()->comment('供应权限 1-开启 2-关闭');
            $table->integer('purchase_jurisdiction')->nullable()->comment('采购权限 1-开启 2-关闭');
            $table->integer('service_jurisdiction')->nullable()->comment('服务权限 1-开启 2-关闭');
            $table->integer('commodity_jurisdiction')->nullable()->comment('商品权限 1-开启 2-关闭');
            $table->integer('status')->nullable()->comment('状态');
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
        Schema::dropIfExists('admin_jurisdiction');
    }
}
