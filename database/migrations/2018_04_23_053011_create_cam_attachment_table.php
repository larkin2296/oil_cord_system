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

            $table->integer('cam_id')->nullable()->comment('卡密id');
            $table->integer('attachment_id')->nullable()->comment('文件id');

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
