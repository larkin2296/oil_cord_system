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

        if( $user->role_status == config('back.global.status.order.complete') || $user->role_status == config('back.global.status.order.refunding') ) {
            return true;
        } else {
            throw new Exception('您没有管理员权限',2);
        }
    }

    /**
     * 验证模块权限
     * return [type] [deception]
     */
    public function checkModalJurisdiction()
    {
        $user = $this->jwtUser();

        if($user->role_status == config('back.global.status.order.refunding') ) {
            return true;
        } else if ($user->role_status == config('back.global.status.order.complete') ) {

          $check = app(\App\Repositories\Interfaces\JurisdictionRepository::class)->findByField(['user_id' => $user->id]);

          if( $check->isNotEmpty() ) {
              return $check;
          } else {
              throw new Exception('您还没有该权限,请联系管理员开通',2);
          }
        }
    }

    /**
     * 权限校验
     * return [type] [deception]
     */
    public function getRoles()
    {
        $user = $this->jwtUser();
        if($user->role_status == config('back.global.status.order.refunding') ) {

            return getCommonCheckValue(true);
        } else if ($user->role_status == config('back.global.status.order.complete') ) {
            return getCommonCheckValue(false);

        }
    }
}