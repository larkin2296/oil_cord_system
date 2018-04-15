<?php
namespace App\Services\Api;

use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Services\Service;
use Exception;
use DB;
use App\Repositories\Models\User;
use JWTAuth;
use Redis;


class RegisterService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait;

    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 注册
     * @return [type] [description]
     */
    public function register()
    {
        //TODO  验证规则
        try {

           $exception =  DB::transaction(function() {

            $mobile = request()->post('mobile');
            $email = request()->post('email');
            $password = request()->post('password');
            $invitation_code = request()->post('invitation_code');
            $code = request()->post('code');

            if($this->userRepo->checkMobile($mobile)) {

                throw new Exception("对不起，手机号已存在！", 2);
            }

            //验证验证码
            $this->checkCode('register', $mobile, $code);

            #TODO 根据生成注册链接里的上一个用户的id 去查询上一个用户是什么角色

           $data = [
               'mobile' => $mobile,
               'email' => $email,
               'password' => bcrypt($password),
               'invitation_code' => $invitation_code,
               'role_status' => 1,
           ];

           User::create($data);

               return ['code' => '200','message' => '注册成功'];
           });
       } catch (Exception $e) {
           dd($e);
           $exception = [
               'code' => '0',
               'message' => $this->handler($e),
           ];
       }
       return array_merge($this->results, $exception);

    }
}