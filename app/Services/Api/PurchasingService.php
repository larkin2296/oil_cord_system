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
use App\Repositories\Models\PurchasingOrder;
use JWTAuth;


class PurchasingService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait,CodeTrait,UserTrait;

    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }
    //将购物车数据添加到数据库
    public function add($request){
        $order = $this->set_order_code(1,1,1);
        try {
            foreach($request['list'] as $val){
                $re = $val;
                $re['order_code'] = $order;
                $this->purorderRepo->create($re);
            }
            return ['code' => '200','message' => '添加成功'];
        } catch (Exception $e) {
            dd($e);
            $exception = [
                'code' => '0',
                'message' => $this->handler($e),
            ];
        }
        return array_merge($this->results, $exception);
    }
}