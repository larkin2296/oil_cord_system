<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTable.
 */
class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('账号');
            $table->string('truename')->nullable()->comment('真实姓名');
            $table->tinyInteger('sex')->nullable()->default(1)->comment('性别,1-男,2-女');
            $table->string('mobile', 15)->nullable()->comment('手机号');
            $table->string('email')->nullable()->comment('邮箱');
            $table->tinyInteger('is_auth')->nullable()->comment('是否认证');
            $table->text('notes')->nullable()->comment('备注');
            $table->string('password')->nullable()->comment('密码');
            $table->string('avatar', 40)->nullable()->comment('头像');
            $table->string('alipay', 40)->nullable()->comment('支付宝帐号');
            $table->string('qq_num', 30)->nullable()->comment('qq号');
            $table->string('invitation_code', 10)->nullable()->comment('邀请码');
            $table->string('city', 30)->nullable()->comment('城市');
            $table->string('role_status', 30)->nullable()->comment('1-采购商2-供应商');
            $table->string('status', 30)->nullable()->default()->comment('状态1-正常2-锁定');
            $table->string('auth_papers', 100)->nullable()->comment('认证的证件图片');
            $table->rememberToken();
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
		Schema::drop('users');
	}
}
