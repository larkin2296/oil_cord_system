<?php

namespace App\Http\Controllers\Api\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\RegisterService as Service;

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

        $results = $this->service->index();

        return response()->json($results);
    }
}
