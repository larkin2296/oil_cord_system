<?php

namespace App\Http\Controllers\Api\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\LoginService as Service;

class LoginController extends Controller
{
    protected $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 登陆
     * @return [type] [description]
     */
    public function login()
    {
        $results = $this->service->login();

        return response()->json($results);
    }

    /**
     * 手机验证码
     * @return [type] [description]
     */
    public function loginMassage()
    {
        $results = $this->service->loginMassage();

        return response()->json($results);
    }

}
