<?php
namespace App\Http\Controllers\Api\System\Supply;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\AuthorityService as Service;
class AuthorityController extends Controller
{

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 权限列表查询
     * @return [type] [description]
     */
    public function index()
    {
        $results = $this->service->index();

        return response()->json($results);
    }

}