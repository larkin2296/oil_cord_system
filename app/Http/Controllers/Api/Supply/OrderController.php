<?php

namespace App\Http\Controllers\Api\Supply;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\UserService as Service;

class OrderController extends Controller
{
    protected $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 更改绑定手机号
     * @return [type] [description]
     */
    public function editMobile()
    {
        $results = $this->service->editMobile();

        return response()->json($results);
    }

    /**
     * 当前登陆用户信息
     * @return [type] [description]
     */
    public function userinfo()
    {
        $results = $this->service->userinfo();

        return response()->json($results);
    }
}
