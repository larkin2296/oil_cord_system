<?php
namespace App\Http\Controllers\Api\System\Supply;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\SystemOrderService as Service;
class OrderManagementController extends Controller
{

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     *卡密订单查询
     * @return [type] [description]
     */
    public function index()
    {
        $results = $this->service->index();

        return response()->json($results);
    }

    /**
     * 直充订单查询
     * @return [type] [deception]
     */
    public function show()
    {
        $results = $this->service->show();

        return response()->json($results);
    }
}