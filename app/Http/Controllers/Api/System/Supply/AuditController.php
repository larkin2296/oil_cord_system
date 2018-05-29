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

    /**
     * 审核状态
     * @return [type] [deception]
     */
    public function store()
    {
        $results = $this->service->store();

        return response()->json($results);
    }


    /**
     * 逻辑删除用户信息
     * return [type] [deception]
     */
    public function destroy()
    {
        $results = $this->service->destroy();

        return response()->json($results);
    }

    /**
     * 已删除用户信息
     * return [type] [deception]
     */
    public function edit()
    {
        $results = $this->service->edit();

        return response()->json($results);
    }

    /**
     * 恢复删除用户
     * return [type] [deception]
     */
    public function restore()
    {
        $results = $this->service->restore();

        return response()->json($results);
    }
}