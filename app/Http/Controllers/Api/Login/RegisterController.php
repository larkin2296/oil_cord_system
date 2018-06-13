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
    public function register( $id = null)
    {
        $results = $this->service->register($id);

        return response()->json($results);
    }

    public function again_check() {
        $results = $this->service->again_check();

        return response()->json($results);
    }

    public function updatePasswd()
    {
        $results = $this->service->updatePasswd();

        return response()->json($results);
    }
}
