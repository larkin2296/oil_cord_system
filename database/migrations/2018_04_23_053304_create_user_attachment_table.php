<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_attachment', function (Blueprint $table) {
            $table->increments('id');


            $table->integer('user_id')->nullable()->comment('用户id');
            $table->integer('attachment_id')->nullable()->comment('文件id');
            $table->integer('status')->nullable()->comment('1-身份证 2-银行卡');
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
        Schema::dropIfExists('user_attachment');
    }
}
