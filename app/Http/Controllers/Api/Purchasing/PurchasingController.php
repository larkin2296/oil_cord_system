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
        $results = $this->service->purorderRepo->findWhere(['order_type'=>1]);
        return response()->json($results);
    }
    //获取长期直充订单查询数据
    public function ldirectly_order(Request $request){
        $results = $this->service->oilcardRepo->findWhere(['is_longtrem'=>1]);
        return response()->json($results);
    }
    //获取短期直充订单查询数据
    public function sdirectly_order(Request $request){
        $results = $this->service->purorderRepo->findWhere(['order_type'=>2]);
        return response()->json($results);
    }
    //油卡绑定功能
    public function binding_card(Request $request){
        $results = $this->service->card_binding($request);
        return response()->json($results);
    }
    //油卡查询
    public function get_card(Request $request){
        $results = $this->service->oilcardRepo->all();
        foreach($results as &$val){
            if($val['card_status'] == 0){
                $val['is_start'] = true;
                $val['status'] = false;
                $val['longtrem'] = false;
                $val['disabled'] = true;
            }else if($val['card_status'] == 1){
                $val['is_start'] = false;
                $val['status'] = '正常';
                $val['longtrem'] = true;
                $val['disabled'] = false;
            }else if($val['card_status'] == 2){
                $val['is_start'] = false;
                $val['status'] = '停用';
                $val['longtrem'] = false;
                $val['disabled'] = false;
            }
        }
        return response()->json($results);
    }
    public function card_start(Request $request){
        $result = $this->service->oilcardRepo->update(['card_status'=>1],$request->card);
            if($result['card_status'] == 0){
                $result['is_start'] = true;
                $result['status'] = false;
                $result['longtrem'] = false;
            }else if($result['card_status'] == 1){
                $result['is_start'] = false;
                $result['status'] = '正常';
                $result['longtrem'] = true;
            }else if($result['card_status'] == 2){
                $result['is_start'] = false;
                $result['status'] = '停用';
                $result['longtrem'] = false;
            }
        return response()->json($result);
    }
    public function set_longtrem(Request $request){
        $result = $this->service->oilcardRepo->update(['is_longtrem'=>1],$request->card);
        return response()->json($result);
    }

    public function get_short_card(){
        $result = $this->service->oilcardRepo->findWhere(['card_status'=>1,'is_longtrem'=>0]);
        $code = [];
        foreach($result as $val){
            $code[] = $val['oil_card_code'];
        }
        return response()->json($code);
    }
    public function directly_order(Request $request){
        $result = $request['list'];
        foreach($result as $key=>$value){
            $arr = implode(',',$value['oil_card_code']);
            $result[$key]['oil_card_code'] = $arr;
        }
        $results = $this->service->add($result);
        return response()->json($results);
    }

    public function get_camilo_detail(){
        
    }
    public function get_ldirectly_detail(){

    }
    public function get_sdirectly_detail(){

    }
    public function set_problem(){

    }
    public function get_initialize(){

    }
    public function get_initialize_detail(){

    }
    public function set_initialize_data(){

    }
    public function get_reconciliation(){

    }
    public function auto_recharge(){

    }
    public function set_camilo_userd(){

    }
}
