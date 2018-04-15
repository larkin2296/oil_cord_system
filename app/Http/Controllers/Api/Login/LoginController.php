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
        $results = $this->service->index();

        return response()->json($results);
    }
    public function get_info(Request $request)
    {

       $result['data'] = $this->service->get_info(['remember_token'=>$request->token]);

       return response()->json($result);
    }
    public function logout(){
        return;
    }
}
