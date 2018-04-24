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
class AccommedService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait,UserTrait;
    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 供应商查询
     * @return [type] [description]
     */
    public function index()
    {
        #TODO 卡密完成再开发
        /*用户信息*/
        $user = $this->jwtUser();

        /*当前用户下的所有订单*/
        $info = $user->hasManyUserOrder()->get()->map(function($item,$key){
            return [
               'id' => $item,
            ];
        });
        dd($info->toArray());
        if(1) {
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

}