<?php
namespace App\Http\Controllers\Api\Supply;

use App\Services\Api\ForwardService as Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Class ForwardController extends Controller{

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 发起提现列表
     * return [type][deception]
     */
    public function index()
    {
        $results = $this->service->index();

        return response()->json($results);
    }

    /**
     * 提现金额
     * return [type][deception]
     */
    public function edit()
    {
        $results = $this->service->edit();

        return response()->json($results);
    }

    /**
     * 提现
     * return [type][deception]
     */
    public function store()
    {
        $results = $this->service->store();

        return response()->json($results);
    }

    /**
     * 提现记录
     * return [type][deception]
     */
    public function show()
    {
        $results = $this->service->presentRecord();

        return response()->json($results);
    }

}