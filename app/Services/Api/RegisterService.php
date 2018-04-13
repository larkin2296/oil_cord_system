<?php
namespace App\Services\Api;

use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Services\Service;
use Exception;
use DB;
use Redis;
use App\User;
use JWTAuth;


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
    public function index()
    {
        //TODO  验证规则
       try {
           $exception =  DB::transaction(function() {
            $name = request()->post('name');
            $truename = request()->post('truename');
            $mobile = request()->post('mobile');
            $email = request()->post('email');
            $password = request()->post('password');
            $invitation_code = request()->post('invitation_code');
            $city = request()->post('city');
            $qq_num = request()->post('qq_num');
            $alipay = request()->post('alipay');
            $code = request()->post('code');

            if($this->userRepo->checkMobile($mobile)) {

                throw new Exception("对不起，手机号已存在！", 2);
            }

            //验证验证码
            $this->checkCode('register', $mobile, $code);

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