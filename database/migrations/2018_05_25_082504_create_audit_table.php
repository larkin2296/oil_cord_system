<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->string('status')->nullable()->comment('状态 1-审核通过 2-审核中 3-审核通过');

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
        Schema::dropIfExists('_audit');
    }
}
