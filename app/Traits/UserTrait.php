<?php

namespace App\Traits;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use JWTAuth;
use Exception;
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

    /**
     * 验证密码
     * @return [type] [description]
     */
    public function checkAuthPasswd($passwd)
    {
        /*获取用户信息*/
        $user = $this->jwtUser();

        if (Hash::check($passwd, $user->password)) {
           return true;
        } else {
           return false;
        }
    }

    /**
     *  根据ID用户信息
     * return [type] [deception]
     */
    public function getIdUserInfo($id)
    {
        return app(UserRepository::class)->find($id);
    }

    /**
     * 验证管理员
     * return [type] [deception]
     */
    public function checkAdminUser()
    {
        $user = $this->jwtUser();

        if( $user->role_status == config('back.global.status.order.complete') ) {
            return true;
        } else {
            throw new Exception('您没有管理员权限',2);
        }
    }

}