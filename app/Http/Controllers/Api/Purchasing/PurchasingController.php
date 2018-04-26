<?php

namespace App\Http\Controllers\Api\Purchasing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $res = $request['list'];
        $results = $this->service->add($res);
        return response()->json($results);
    }
    //获取卡密订单查询数据
    public function get_camilo_order(Request $request){
        $results = $this->service->get_data('purchasing_order',['order_type'=>1]);
        return response()->json($results);
    }
    //获取长期直充订单查询数据
    public function ldirectly_order(Request $request){
        $results = $this->service->get_data('user_oil_card',['is_longtrem'=>1]);
        return response()->json($results);
    }
    //获取短期直充订单查询数据
    public function sdirectly_order(Request $request){
        $results = $this->service->get_data('purchasing_order',['order_type'=>2]);
        return response()->json($results);
    }
    //油卡绑定功能
    public function binding_card(Request $request){
        $results = $this->service->card_binding($request);
        return response()->json($results);
    }
    //油卡查询
    public function get_card(Request $request){
        $results = $this->service->get_card();
        return response()->json($results);
    }
    public function card_start(Request $request){
        $result = $this->service->card_start($request);
        return response()->json($result);
    }
    public function set_longtrem(Request $request){
        $result = $this->service->oilcardRepo->update(['is_longtrem'=>1],$request->card);
        return response()->json($result);
    }

    public function get_short_card(){
        $result = $this->service->get_short_card('user_oil_card',['card_status'=>1,'is_longtrem'=>0]);
        return response()->json($result);
    }
    public function directly_order(Request $request){
        $results = $this->service->directly_order($request);
        return response()->json($results);
    }

    public function get_camilo_detail(Request $request){
//        $results = $this->service->get_data('purchasing_camilo_detail',['order_code'=>$request['order_code']]);
//        return response()->json($results);
    }
    public function get_ldirectly_detail(){
        $results = $this->service->get_ldirectly_detail();
        return response()->json($results);
    }
    public function get_sdirectly_detail(){
        $results = $this->service->get_sdirectly_detail();
        return response()->json($results);
    }
    public function set_problem(){
        $results = $this->service->set_problem();
        return response()->json($results);
    }
    public function get_initialize(){
        $results = $this->service->get_initialize();
        return response()->json($results);
    }
    public function get_initialize_detail(){
        $results = $this->service->get_initialize_detail();
        return response()->json($results);
    }
    public function set_initialize_data(){
        $results = $this->service->set_initialize_data();
        return response()->json($results);
    }
    public function get_reconciliation(){

    }
    public function auto_recharge(){
        $results = $this->service->auto_recharge();
        return response()->json($results);
    }
    public function set_camilo_userd(){
        $results = $this->service->set_camilo_userd();
        return response()->json($results);
    }
}
