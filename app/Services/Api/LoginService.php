<?php
namespace App\Services\Api;
use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Traits\UserTrait;
use App\Services\Service;
use Exception;
use DB;
use Redis;
use App\User;
use JWTAuth;
class LoginService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait,UserTrait;
    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 帐号密码登陆
     * @return [type] [description]
     */
    public function login()
    {
        //TODO  验证规则
        $mobile = request('mobile', '');
        $password = request('password', '');
        $credentials = request()->only('mobile', 'password');
        if( $token = JWTAuth::attempt($credentials) ) {
            $user = $this->userRepo->findByField('mobile', $mobile)->first();
        } else {
            throw new Exception('帐号密码不正确', 2);
        }
        $exception = [
            'code' => '200',
            'data' => [
                'user' => $this->getLoginUserInfo($user),
                'token' => $token,
            ]
        ];
        return array_merge($this->results, $exception);
    }
    /**
     * 短信验证码登录
     * @return [type] [description]
     */
    public function loginMassage()
    {
        /*事务处理*/
        $exception = DB::transaction(function(){
            $mobile = request('mobile', '');
            $code = request('code', '');

            //验证验证码
            $this->checkCode('login', $mobile, $code);
            //验证手机号是否存在
            if( !$user = $this->userRepo->findByField('mobile', $mobile)->first() ) {
                /*创建帐号*/
                $user = $this->userRepo->create([
                    'mobile' => $mobile,
                    'name' => $mobile,
                    'password' => '123456',
                ]);
                /*抛出用户添加事件*/
                /*重新获取用户*/
                $user = $this->userRepo->find($user->id);
            }
            $token = JWTAuth::fromUser($user);
            return [
                'code' => '200',
                'data' => [
                    'token' => $token,
                    'user' => $this->getLoginUserInfo($user),
                ],
            ];
        });
        return array_merge($this->results, $exception);
    }
}