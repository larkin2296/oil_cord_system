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
class ConfigureService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait,UserTrait;
    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }
    public function get_oil_card() {
        $post = request()->post('list','');
        $user = $this->jwtUser();
        $result = $this->oilcardRepo->findWhere(['user_id'=>$user->id])->map(function($item,$index){
           return [
             'oil_card_code' => $item['oil_card_code'],
             'id' => $item['id']
           ];
        });
        return ['code' => 200, 'message' => '获取油卡信息成功','data' => $result];
    }

}