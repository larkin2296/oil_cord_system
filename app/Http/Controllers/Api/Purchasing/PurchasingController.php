<?php

namespace App\Http\Controllers\Api\Purchasing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\PurchasingService as Service;

class PurchasingController extends Controller
{
    protected $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    //购物车添加接口
    public function camilo_order(Request $request){
        $results = $this->service->add($request);
        return response()->json($results);
    }
    //获取卡密订单查询数据
    public function get_camilo_order(Request $request){

    }
    //获取直充订单查询数据
    public function get_directy_order(Request $request){

    }
    //油卡绑定功能
    public function binding_card(Request $request){
        return $request;
    }
}
