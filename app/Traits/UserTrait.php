<?php

namespace App\Traits\Services\User;

use Carbon\Carbon;
use JWTAuth;

Trait UserTrait
{
    /**
     * 获取登录用户信息
     * @return [type] [description]
     */
    public function getLoginUserInfo($user)
    {
        return [
            'name' => $user->name ?: $user->mobile,
            'truename' => $user->truename ?: $user->mobile,
            'mobile' => $user->mobile,
            //'avatar' => $user->avatar ? dealAvatar($user->avatar): '',
            'role_status' => $user->role_status ? $user->role_statu : '',
            'grade' => $user->grade ? $user->grade: '',
            'password' => $user->password,
        ];
    }

    /**
     * jwt 请求资源的用户
     * @return [type] [description]
     */
    public function jwtUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }
}