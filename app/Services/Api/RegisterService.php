<?php
namespace App\Services\Api;

use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\EncryptTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Services\Service;
use Exception;
use DB;
use App\User;
use JWTAuth;
use phpDocumentor\Reflection\Types\Integer;
use Redis;
use Hashids\Hashids;

class RegisterService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait, EncryptTrait;

    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 注册
     * @return [type] [description]
     */
    public function register($id)
    {
        //TODO  验证规则
        try {

           $exception =  DB::transaction(function() use ($id){

            $mobile = request()->post('mobile');
            $email = request()->post('email');
            $password = request()->post('password');
            $invitation_code = request()->post('invitation_code');
            $code = request()->post('code');

               if($this->userRepo->checkedMobile($mobile)) {

                throw new Exception("对不起，手机号已存在！", 2);
            }

            //验证验证码
            $this->checkCode('register', $mobile, $code);

            /*验证邀请人角色*/
            $register =  $this->checkRegisterId($id);

           $data = [
               'mobile' => $mobile,
               'email' => $email,
               'password' => bcrypt($password),
               'invitation_code' => $invitation_code,
               'role_status' => $register->role_status ?? 0,
               'invitation_id' => $register->id ?? '',

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

    /*验证邀请人id*/
    public function checkRegisterId($id)
    {
        if( isset($id) ) {
            $registerId =  $this->decodeId($id)[0];

            $register = $this->userRepo->find($registerId);

            return $register;

        } else {

            /*直接返回id*/
            return $id ?? '';

        }
    }
}