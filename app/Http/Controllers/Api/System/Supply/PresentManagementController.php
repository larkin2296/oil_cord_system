<?php
namespace App\Http\Controllers\Api\System\Supply;

use App\Services\Api\PresentService as Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

Class PresentManagementController extends Controller {

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 提现金额设置列表
     * return [type] [deception]
     */
    public function index()
    {
        $results = $this->service->index();

        return response()->json($results);
    }

    /**
     * 提现管理金额设置
     * return [type] [deception]
     */
    public function update()
    {

        $results = $this->service->update();

        return response()->json($results);
    }


}