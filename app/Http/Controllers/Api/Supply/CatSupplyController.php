<?php
namespace App\Http\Controllers\Api\Supply;

use App\Services\APi\CatSupplyService as Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Class CatSupplyController extends Controller{

    public function __construct(Service $service)
    {

        $this->service = $service;

    }


    /**
     * 卡密供货
     * return [type][deception]
     */
    public function create()
    {
        $results = $this->service->create();

        return response()->json($results);
    }
    /**
     * 平台金额
     * return [type\[deception]
     */
    public function show()
    {
        $results = $this->service->show();

        return response()->json($results);
    }
}