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
     * return [type] [deception]
     */
    public function index()
    {
        $results = $this->service->index();

        return response()->json($results);
    }

    /**
     * 查看订单详情
     * return [type] [description]
     */
    public function show($id)
    {
        $results = $this->service->show($id);

        return response()->json($results);
    }

    /**
     * 直充供货查询
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function charge()
    {
        $results = $this->service->chargeQuery();

        return response()->json($results);
    }

    /**
     * 查看直充详情
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function attachmentCharge($id)
    {
        $results = $this->service->attachmentCharge($id);

        return response()->json($results);

    }

}
