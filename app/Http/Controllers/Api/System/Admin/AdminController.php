<?php

namespace App\Http\Controllers\Api\System\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\AdminService as Service;

class AdminController extends Controller
{
    protected $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 管理员管理
     * @return [type] [description]
     */
    public function index()
    {
        $results = $this->service->index();

        return response()->json($results);
    }
    /**
     * 管理员添加
     * @return [type] [description]
     */
    public function create()
    {
        $results = $this->service->create();

        return response()->json($results);
    }

    /**
     * 管理员权限设定
     * @return [type] [deception]
     */
    public function setAdmin()
    {
        $results = $this->service->setAdmin();

        return response()->json($results);
    }


}
