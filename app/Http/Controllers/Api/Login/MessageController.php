<?php

namespace App\Http\Controllers\Api\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\MessageService as Service;
use App\Http\Requests\MobileValidRequest;

class MessageController extends Controller
{
    protected $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 发送登录短信验证码
     * @return [type] [description]
     */
    public function loginMessage(MobileValidRequest $request)
    {

        $results = $this->service->loginMessage();

        return response()->json($results);
    }

    /**
     * 发送注册短信验证码
     * @return [type] [description]
     */
    public function registerMessage(MobileValidRequest $request)
    {
        $results = $this->service->registerMessage();

        return response()->json($results);
    }

    /**
     * 发送重置短信验证码
     * @return [type] [description]
     */
    public function resetpassMessage(MobileValidRequest $request)
    {
        $results = $this->service->resetpassMessage();
        return response()->json($results);
    }
    /**
     * 发送更改手机号绑定验证码
     * @return [type] [description]
     */
    public function editMobileMessage(MobileValidRequest $request)
    {
        $results = $this->service->editMobileMessage();

        return response()->json($results);
    }
}
