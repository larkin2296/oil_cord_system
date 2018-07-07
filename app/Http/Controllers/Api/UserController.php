<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\UserService as Service;

class UserController extends Controller
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

    /**
     * 修改当前用户信息
     * @return [type] [description]
     */
    public function updateUser()
    {
        $results = $this->service->updateUser();

        return response()->json($results);
    }

    /**
     * 修改用户密码
     * @return [type] [description]
     */
    public function updatePasswd()
    {
        $results = $this->service->updatePasswd();

        return response()->json($results);
    }

    /**
     * 生成邀请链接
     * @return [type] [description]
     */
    public function setLink()
    {
        $results = $this->service->setLink();

        return response()->json($results);
    }

    public function editAvatar()
    {
        $results = $this->service->editAvatar();

        return response()->json($results);
    }

    public function showAvatar($id)
    {
        $results = $this->service->showAvatar($id);

        return response()->file($results);
    }

    /**
     * 查看已邀请人数
     * @return [type] [description]
     */
    public function show()
    {
        $results = $this->service->show();

        return response()->json($results);
    }

    public function refresh_token()
    {
        $results = $this->service->updateToken();

        return $results;
    }

}
