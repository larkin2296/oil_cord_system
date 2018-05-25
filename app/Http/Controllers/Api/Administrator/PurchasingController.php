<?php

namespace App\Http\Controllers\Api\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\AdministratorService as Service;

class PurchasingController extends Controller
{
    protected $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function get_camilo(){
        $results = $this->service->get_camilo_list();
        return response()->json($results);
    }
    public function get_directly() {
        $results = $this->service->get_directly_list();
        return response()->json($results);
    }
    public function get_sdirectly() {
        $results = $this->service->get_sdirectly_list();
        return response()->json($results);
    }
    public function send_camilo(){
        $results = $this->service->send_camilo();
        return response()->json($results);
    }

    //油卡获取
    public function get_purchasing_card() {
        $results = $this->service->get_card();
        return response()->json($results);
    }
    //采购商获取
    public function get_purchasing_user() {
        $results = $this->service->get_purchasing_user();
        return response()->json($results);
    }
    //采购商权限修改
    public function set_user_perrmission() {
        $results = $this->service->set_user_perrmission();
        return response()->json($results);
    }
    //短期充值
    public function charge() {
        $results = $this->service->charge();
        return response()->json($results);
    }
    //短期充值详情
    public function get_sdirectly_detail() {
        $results = $this->service->get_sdirectly_detail();
        return response()->json($results);
    }
}
