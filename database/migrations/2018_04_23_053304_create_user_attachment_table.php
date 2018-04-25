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

            $table->string('name')->nullable()->comment('文件存储名称');
            $table->string('origin_name')->nullable()->comment('文件原始名称');
            $table->string('size')->nullable()->comment('文件大小');
            $table->string('path')->nullable()->comment('文件上传路径');
            $table->string('ext')->nullable()->comment('文件扩展');
            $table->string('ext_info')->nullable()->comment('文件扩展信息');
            $table->integer('user_id')->nullable()->comment('用户id');
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
