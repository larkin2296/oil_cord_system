<?php
namespace App\Services\Api;

use App\Repositories\Models\Audit;
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
            $code = request()->post('code');
               /*解秘ID*/
               $id = $this->decodeId($id);
               if($this->userRepo->checkedMobile($mobile)) {

                throw new Exception("对不起，手机号已存在！", 2);
            }

            //验证验证码
            $this->checkCode('register', $mobile, $code);

            /*验证邀请人角色*/
            $register =  $this->checkRegisterId($id);

            if($register->recommend_status == getCommonCheckValue(false)){
                throw new Exception('当前邀请人没有邀请权限,请联系管理员',2);
            }

           $data = [
               'mobile' => $mobile,
               'email' => $email,
               'password' => bcrypt($password),
               'role_status' => $register->role_status ?? 0,
               'invitation_id' => $register->id ?? '',
           ];

           $user = User::create($data);

           Audit::create(['user_id' => $user->id]);

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
            $registerId =  $this->decodeId($id);

            $register = $this->userRepo->find($registerId);

            return $register;

        } else {

            /*直接返回id*/
            return $id ?? '';

        }
    }
}