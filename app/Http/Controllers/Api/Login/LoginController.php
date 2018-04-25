<?php

namespace App\Http\Controllers\Api\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\LoginService as Service;
use Illuminate\Auth as Auth;

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

    public function get_info(Request $request)
    {

        $result['data'] = $this->service->get_info(['remember_token'=>$request->token]);

       return response()->json($result);
    }
    public function logout(){
    }
}
