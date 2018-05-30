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

    public function setData($user,$data)
    {
       $data =  $this->checkRole($user,$data);
       return $data;
    }

    public function checkRole($user,$data)
    {
        //管理员不可以设定超级管理员 超级管理员可以设定管理员与超级管理员
        if( !$role = $user->role_status ) {
            throw new Exception('您没有操作当前功能的权限',2);
        }

        if( $role == config('back.global.status.order.refunding') ){
           return [
                'name' => $data['name'],
                'password' => bcrypt($data['password']),
                'truename' => $data['truename'],
                'sex' => $data['sex'],
                'mobile' => $data['mobile'],
                'role_status' => $data['role_status'],
                'invitation_id' => $user->id
            ];
        } else if( $role == config('back.global.status.order.complete') ) {
            return [
                'name' => $data['name'],
                'password' => bcrypt($data['password']),
                'truename' => $data['truename'],
                'sex' => $data['sex'],
                'mobile' => $data['mobile'],
                'role_status' => config('back.global.status.order.complete'), //管理员
                'invitation_id' => $user->id
            ];
        }
    }



}