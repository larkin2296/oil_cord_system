<?php

namespace App\Http\Controllers\Api\Configure;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\ConfigureService as Service;

class ConfigureController extends Controller
{
    protected $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function get_platform_list(){
        $this->service->checkCommodityAdminJurisdiction();
        $results = $this->service->platformRepo->all();
        foreach($results as $key=>$value) {
            $results[$key]['edit'] = false;
            $results[$key]['edit1'] = false;
        }
        return response()->json($results);
    }
    public function get_denomination_list(){
        $this->service->checkCommodityAdminJurisdiction();
        $results = $this->service->platformMoneyRepo->orderBy('denomination','asc')->all();
        return response()->json($results);
    }
    public function add_platform(Request $request){
        $this->service->checkCommodityAdminJurisdiction();
        $results = $this->service->platformRepo->create($request['list']);
        return response()->json($results);
    }
    public function add_denomination(Request $request){
        $this->service->checkCommodityAdminJurisdiction();
        $results = $this->service->platformMoneyRepo->create($request['list']);
        return response()->json($results);
    }
    public function get_config_detail(){
        $results = $this->service->get_config_data();
        return response()->json($results);
    }
    //获取用户油卡
    public function get_oil_card() {
        $results = $this->service->get_oil_card();
        return response()->json($results);
    }
    //获取配置数据
    public function get_config_set() {
        $results = $this->service->get_config_set();
        return response()->json($results);
    }
    //更改配置
    public function save_config() {
        $results = $this->service->save_config();
        return response()->json($results);
    }
    //获取权限
    public function get_permission() {
        $results = $this->service->get_permission();
        return response()->json($results);
    }
    //修改平台折扣
    public function save_platform_discount() {
        $results = $this->service->save_platform_discount();
        return response()->json($results);
    }
    //获取平台面额折扣
    public function get_discount_data() {
        $results = $this->service->get_discount_data();
        return response()->json($results);
    }
    //修改平台面额折扣
    public function save_discount_data() {
        $results = $this->service->save_discount_data();
        return response()->json($results);
    }
}
