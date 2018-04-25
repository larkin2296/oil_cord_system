<?php

namespace App\Http\Controllers\Api\Supply;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\AccommedService as Service;

class OrderController extends Controller
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 卡密供货查询
     * @return [type] [description]
     */
    public function index()
    {
        $results = $this->service->index();

        return response()->json($results);
    }

    /**
     * 查看订单详情
     * @return [type] [description]
     */

}
