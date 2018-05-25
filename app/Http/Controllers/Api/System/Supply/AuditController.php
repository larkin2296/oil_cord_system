<?php
namespace App\Http\Controllers\Api\System\Supply;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\AuditService as Service;
class AuditController extends Controller
{

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 审核管理列表
     * @return [type] [description]
     */
    public function index()
    {
        $results = $this->service->index();

        return response()->json($results);
    }

}