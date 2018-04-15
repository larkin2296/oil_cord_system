<?php

namespace App\Traits;
use PhpRedis;
use Exception;

Trait CodeTrait
{
    public function checkCode($action, $mobile, $verifyCode)
    {

        $key = $this->getCodeKey($mobile, $action);

        if(	PhpRedis::command('exists', [$key]) ) {
            $code = $this->getRedis($key);


            if( $code == $verifyCode ) {
                $this->clearRedis($key);
                return true;
            }
        }

        throw new Exception("验证码错误", 2);
    }

    private function checkCount($mobile, $default = 5)
    {
        $key = $this->getCountKey($mobile);

        if( PhpRedis::command('exists', [$key]) ) {
            $count = $this->getRedis($key);

            if( $count && $count <= $default ) {
                return true;
            }
        } else {
            return true;
        }
        if (env('APP_DEBUG')) {
            return true;
        }

        throw new Exception("短信发送次数过多", 2);
    }

    private function getRedis($key)
    {
        return PhpRedis::command('get', [$key]);
    }
    /**
     * 设置Redis
     *
     */
    private function setRedis($key, $value)
    {
        PhpRedis::set($key, $value);
    }

    private function clearRedis($key)
    {
        PhpRedis::command('DEL', [$key]);
    }

    private function setExpire($key, $expire)
    {
        PhpRedis::expire($key, $expire);
    }

    private function getCodeKey($mobile, $action)
    {
        //验证码
        $codeKey = $mobile . ':code:';
        return $codeKey . $action;
    }

    private function getCountKey($mobile)
    {
        // 总量
        return $mobile . ':count';
    }



}