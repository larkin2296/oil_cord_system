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
}
