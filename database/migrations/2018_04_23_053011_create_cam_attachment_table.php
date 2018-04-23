<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCamAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cam_attachment', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable()->comment('文件存储名称');
            $table->string('origin_name')->nullable()->comment('文件原始名称');
            $table->string('size')->nullable()->comment('文件大小');
            $table->string('path')->nullable()->comment('文件上传路径');
            $table->string('ext')->nullable()->comment('文件扩展');
            $table->string('ext_info')->nullable()->comment('文件扩展信息');
            $table->integer('supply_id')->nullable()->comment('供应单id');
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
        Schema::dropIfExists('cam_attachment');
    }
}
