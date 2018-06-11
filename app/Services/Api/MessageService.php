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
use PhpRedis;
use HskyZhou\NineOrange\NineOrange;

class MessageService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait;

    protected $builder;
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 发送登录短信验证码
     * @return [type] [description]
     */
    public function loginMessage()
    {
        try {
            //验证手机
            $mobile = request('mobile', '');

            //验证发送次数
            $info = $this->checkCount($mobile);

            //发送验证码
            //$template = "您的验证码是%u请不要告诉任何人,30分钟内有效,如非本人操作,请忽略本短信.";
            $template = "您的验证码为%u.";
            $code = $this->sendCode('login', $mobile, $template);
            $message = '发送成功';
            if( env('APP_DEBUG') ) {
                $message = $message . $code;
            }
            return array_merge($this->results, ['code' => '200','message' => $message]);
        } catch (Exception $e) {
            $exception = [
                'code' => '0',
                'message' => $e->getMessage(),
            ];
        }
        return array_merge($this->results, $exception);
    }


    /**
     * 发送注册短信验证码
     * @return [type] [description]
     */
    public function registerMessage()
    {
        try {

            $mobile = request()->get('mobile');

            //验证手机号是否正确
            if ( $this->userRepo->checkedMobile($mobile) ) {
                throw new Exception("对不起，手机号已存在！", 2);
            }

            //验证发送次数
            $this->checkCount($mobile);

            //发送验证码
            //$template = "您的验证码是%u请不要告诉任何人,30分钟内有效,如非本人操作,请忽略本短信.";
            $template = "您的验证码为%u.";

            $code = $this->sendCode('register', $mobile, $template);

            $message = '发送成功';
            if( env('APP_DEBUG') ) {
                $message = $message . $code;
            }
            return array_merge($this->results, ['code' => '200','message' => $message]);

        } catch (Exception $e) {
            $exception = [
                'code' => '0',
                'message' => $e->getMessage(),
            ];
        }

        return array_merge($this->results, $exception);
    }

    /**
     * 发送重置短信验证码
     * @return [type] [description]
     */
    public function resetpassMessage()
    {
        try {
            $mobile = request()->get('mobile');

            if ( !$this->userRepo->checkedMobile($mobile) ) {
                throw new Exception("对不起，手机号不存在！", 2);
            }

            //验证发送次数
            $this->checkCount($mobile);

            //发送验证码
            //$template = "您的验证码是%u请不要告诉任何人,30分钟内有效,如非本人操作,请忽略本短信.";
            $template = "您的验证码为%u.";

            $code = $this->sendCode('resetpass', $mobile, $template);

            $message = '发送成功';
            if( env('APP_DEBUG') ) {
                $message = $message . $code;
            }
            return array_merge($this->results, ['code' => '200','message' => $message]);


        } catch (Exception $e) {
            $exception = [
                'code' => '0',
                'message' => $e->getMessage(),
            ];
        }

        return array_merge($this->results, $exception);
    }

    /**
     * 发送更改手机号绑定验证码
     * @return [type] [description]
     */
    public function editMobileMessage()
    {
        try {
            $mobile = request()->get('mobile');

            if ( $this->userRepo->checkedMobile($mobile) ) {
                throw new Exception("对不起，手机号已存在！", 2);
            }

            //验证发送次数
            $this->checkCount($mobile);

            //发送验证码
            //$template = "您的验证码是%u请不要告诉任何人,30分钟内有效,如非本人操作,请忽略本短信.";
            $template = "您的验证码为%u.";

            $code = $this->sendCode('editMobile', $mobile, $template);

            $message = '发送成功';
            if( env('APP_DEBUG') ) {
                $message = $message . $code;
            }
            return array_merge($this->results, ['code' => '200','message' => $message]);

        } catch (Exception $e) {
            $exception = [
                'code' => '0',
                'message' => $e->getMessage(),
            ];
        }

        return array_merge($this->results, $exception);
    }


    /**
     * @param $mobile 手机号
     * @param $template 模版
     */
    private function sendCode($action, $mobile, $template)
    {
        //验证码
        $code =  rand(100000,999999);
        // 发送验证码
        if( env('APP_DEBUG') ) {
            //存储验证码
            $this->setVerifyCode($action, $mobile, $code);
        } else {
            $data = [
                $code
            ];

            $nineorange = new NineOrange;
            $send_result = $nineorange->sendCustom($template, $data, $mobile);

            if ( $send_result['result'] ) {
                //存储验证码
                $result = $this->setVerifyCode($action, $mobile, $code);
            } else {
                throw new Exception("短信发送次数过多", 1);

            }
        }
        return $code;
    }

    /**
     * 记录短信验证码
     * @param  string $action  执行动作
     * @param  number $mobile  手机号
     * @param  number $code    验证码
     * @return [type] [description]
     */
    public function setVerifyCode($action, $mobile, $value, $expire = 0)
    {
        $codeKey = $this->getCodeKey($mobile, $action);
        $countKey = $this->getCountKey($mobile);
        $expire = $expire ?: 1800;
        $this->setRedis($codeKey, $value);
        $this->setExpire($codeKey, $expire);
        PhpRedis::INCR($countKey);
        $this->setExpire($countKey, 86400);
    }
}