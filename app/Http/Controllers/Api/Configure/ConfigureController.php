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
        $results = $this->service->platformRepo->all();
        return response()->json($results);
    }
    public function get_denomination_list(){
        $results = $this->service->platformMoneyRepo->all();
        return response()->json($results);
    }
    public function add_platform(Request $request){
        $results = $this->service->platformRepo->create($request['list']);
        return response()->json($results);
    }
    public function add_denomination(Request $request){
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
}
