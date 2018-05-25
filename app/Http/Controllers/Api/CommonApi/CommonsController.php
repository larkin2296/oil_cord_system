<?php
namespace App\Http\Controllers\Api\CommonApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\DataCommonsService as Service;

Class CommonsController extends Controller {

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 获取所有供应商
     * return [type] [deception]
     */
    public function getSupplierAll()
    {

        $results = $this->service->getSupplierAll();

        return response()->json($results);
    }

    /**
     * 获取所有采购商
     * return [type] [deception]
     */
    public function getPurchasersAll()
    {

        $results = $this->service->getPurchasersAll();

        return response()->json($results);
    }

    /**
     * 获取所有管理员
     * return [type] [deception]
     */
    public function getAdminAll()
    {

        $results = $this->service->getAdminAll();

        return response()->json($results);
    }

    /**
     * 验证用户权限
     * return [type] [deception]
     */
    public function checkUserOauth()
    {
        $results = $this->service->checkUserOauth();

        return response()->json($results);
    }
}