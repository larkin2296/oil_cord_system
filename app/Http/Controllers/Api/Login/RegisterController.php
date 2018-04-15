<?php

namespace App\Http\Controllers\Api\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\RegisterService as Service;

use Illuminate\Http\Response;

use App\Http\Requests;
class RegisterController extends Controller
{
    protected $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 注册
     * @return [type] [description]
     */
    public function register()
    {

        $results = $this->service->register();

        return response()->json($results);
    }


}
