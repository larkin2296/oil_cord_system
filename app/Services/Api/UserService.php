<?php
namespace App\Services\Api;
use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\UserTrait;
use App\Services\Service;
use App\Traits\CodeTrait;
use Carbon\Carbon;
use Exception;
use DB;
use Storage;
use JWTAuth;

class UserService extends Service
{
    use ServiceTrait, ResultTrait, ExceptionTrait, UserTrait,CodeTrait;

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 更改手机号绑定
     * @return [type] [description]
     */
    public function editMobile()
    {
        $exception =  DB::transaction(function() {
            $mobile = request('mobile','');
            $code = request('code','');
            /*获取请求资源用户*/
            $user = $this->jwtUser();

            //验证验证码
            $this->checkCode('editMobile', $mobile, $code);

            $result = $this->userRepo->update(['mobile'=>$mobile],$user->id);
            if ($result) {
                return ['code' => '200','message' => '修改成功'];
            } else {
                return ['message' => '修改失败'];
            }
        });

        return array_merge($this->results, $exception);
    }

    /**
     * 个人信息
     * @return [type] [description]
     */
    public function userInfo()
    {
        $user = $this->jwtUser();

        $result = $this->userRepo->find($user->id);
        // 头像路径
        $data = [
            'id' => $result->id ?: $result->id,
            'name' => $result->truename ?: $result->mobile,
            'truename' => $result->truename ?: $result->mobile,
            'sex' => $result->sex ? $result->sex: '',
            'mobile' => $result->mobile,
            'email' => $result->email ? $result->email : '',
            'alipay' => $result->alipay ? $result->alipay : '',
            'qq_num' => $result->qq_num ? $result->qq_num : '',
            'grade' => $result->grade ? $result->grade : '',
            'notes' => $result->notes ? $result->notes : '',
            'roles' => $result->role_status ? [$result->role_status] : '',
//            'avatar' => dealAvatar($result->avatar),
        ];
        return array_merge($this->results,['code' => '200','data' => $data,'message' => '请求成功']);

    }
}