<?php
namespace App\Http\Controllers\Api\Supply;

use App\Services\Api\CatSupplyService as Service;
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

    /**
     * 卡密供货-导入
     * return [type\[deception]
     */
    public function import()
    {
        $results = $this->service->importExcelData();

        return response()->json($results);
    }

    /**
     * 卡密供货-显示
     * return [type\[deception]
     */
    public function lists()
    {
        $results = $this->service->importExcelShow();
        dd($results);
        return response()->json($results);
    }

    /**
     * 模版导出
     * return [type\[deception]
     */
    public function export()
    {
        $results = $this->service->export();

        return response()->json($results);
    }

    /**
     * 直充供货
     * return [type\[deception]
     */
    public function charge()
    {
        $results = $this->service->charge();

        return response()->json($results);
    }

    /**
     * 油卡列表
     * return [type][deception]
     */
    public function relationship()
    {
        $results = $this->service->relationshipSupply();

        return response()->json($results);
    }
}