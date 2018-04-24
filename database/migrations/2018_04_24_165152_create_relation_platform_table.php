<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationPlatformTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_platform', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supply_id')->nullable()->comment('供应单id');
            $table->integer('platform_id')->nullable()->comment('平台表id');
            $table->integer('money_id')->nullable()->comment('金额表id');

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
        Schema::dropIfExists('relation_plaform');
    }
}
