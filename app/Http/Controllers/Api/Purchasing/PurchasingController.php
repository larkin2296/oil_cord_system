<?php

namespace App\Http\Controllers\Api\Purchasing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Services\Api\PurchasingService as Service;
use Mockery\Exception;

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
        foreach($res as $val){
            $results = $this->service->add($val);
        }
        return response()->json($results);
    }
    //获取卡密订单查询数据
    public function get_camilo_order(){
        $results = $this->service->get_camilo_order();
        return response()->json($results);
    }
    //获取长期直充订单查询数据
    public function ldirectly_order(Request $request){
        $results = $this->service->ldirectly_order($request);
        return response()->json($results);
    }
    //获取短期直充订单查询数据
    public function sdirectly_order(Request $request){
        $results = $this->service->sdirectly_order($request);
        return response()->json($results);
    }
    //油卡绑定功能
    public function binding_card(){
        $results = $this->service->card_binding();
        return response()->json($results);
    }
    //油卡查询
    public function get_card(Request $request){
        $results = $this->service->get_card();
        return response()->json($results);
    }
    public function get_oilcard_upload() {
        $result = $this->service->get_oilcard_upload();
        return response()->json($result);
    }
    //油卡启动
    public function card_start(Request $request){
        $result = $this->service->card_start($request);
        return response()->json($result);
    }
    //油卡删除
    public function del_card(){
        $result = $this->service->del_card();
        return response()->json($result);
    }
    //设置长期
    public function set_longtrem(Request $request){
        $result = $this->service->oilcardRepo->update(['is_longtrem'=>1],$request->card);
        return response()->json($result);
    }
    //获取短期卡
    public function get_short_card(){
        $result = $this->service->get_short_card('user_oil_card',['card_status'=>1,'is_longtrem'=>0]);
        return response()->json($result);
    }
    //添加直充短充订单
    public function directly_order(Request $request){
        $results = $this->service->directly_order($request);
        return response()->json($results);
    }
    //获取卡密详情
    public function get_camilo_detail(Request $request){
        $results = $this->service->get_camilo_detail();
        return response()->json($results);
    }
    //获取长充详情
    public function get_ldirectly_detail(){
        $results = $this->service->get_ldirectly_detail();
        return response()->json($results);
    }
    //获取短充详情
    public function get_sdirectly_detail(){
        $results = $this->service->get_sdirectly_detail();
        return response()->json($results);
    }
    //设置问题卡密
    public function set_problem(){
        $results = $this->service->set_problem();
        return response()->json($results);
    }
    //获取圈存
    public function get_initialize(){
        $results = $this->service->get_initialize();
        return response()->json($results);
    }
    //获取圈存详情
    public function get_initialize_detail(){
        $results = $this->service->get_initialize_detail();
        return response()->json($results);
    }
    //设置圈存数据
    public function set_initialize_data(){
        $results = $this->service->set_initialize_data();
        return response()->json($results);
    }
    public function get_reconciliation(){

    }
    //自动补发
    public function auto_recharge(){
        $results = $this->service->auto_recharge();
        return response()->json($results);
    }
    //设置卡密已使用
    public function set_camilo_userd(Request $request){
        try{
            foreach($request['order'] as $value){
                $this->service->set_camilo_userd($value['id'],$value['cam_name']);
            }
            return response()->json(['code'=>200,'msg'=>'修改成功']);
        }catch(Exception $e){
            return response()->json($e);
        }
    }
    //更改卡密状态
    public function confirm_status() {
        $results = $this->service->confirm_status();
        return response()->json($results);
    }
    //提交圈存记录
    public function send_initialize() {
        $results = $this->service->send_initialize();
        return response()->json($results);
    }
    //获取对账数据
    public function get_reconciliation_data() {
        $results = $this->service->get_reconciliation_data();
        return response()->json($results);
    }
    //设置对账单
    public function set_reconciliation_data() {
        $results = $this->service->set_reconciliation_data();
        return response()->json($results);
    }
    //获取对账单
    public function get_reconciliation_list() {
        $results = $this->service->get_reconciliation_list();
        return response()->json($results);
    }
    //获取对账详情
    public function get_reconciliation_detail() {
        $results = $this->service->get_reconciliation_detail();
        return response()->json($results);
    }
    //删除短充
    public function del_short_order() {
        $results = $this->service->del_short_order();
        return response()->json($results);
    }

    public function get_search_card() {
        $results = $this->service->get_search_card();
        return response()->json($results);
    }
}
