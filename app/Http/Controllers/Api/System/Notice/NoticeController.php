<?php
namespace App\Http\Controllers\Api\System\Notice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\NoticeService as Service;
Class NoticeController extends Controller {

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * 管理员公告列表
     * @return [type] [deception]
     */
    public function index()
    {
        $results = $this->service->index();

        return response()->json($results);
    }

    /**
     * 管理员新增公告
     * @return [type] [deception]
     */
    public function add()
    {
        $results = $this->service->addNotice();

        return response()->json($results);
    }

    /**
     * 管理员修改公告
     * @return [type] [deception]
     */
    public function update()
    {
        $results = $this->service->updateNotice();

        return response()->json($results);
    }

    /**
     * 管理员修改公告
     * @return [type] [deception]
     */
    public function choice()
    {
        $results = $this->service->choiceNotice();

        return response()->json($results);
    }

    /**
     * 管理员删除公告
     * @return [type] [deception]
     */
    public function delete($id)
    {
        $results = $this->service->destroyNotice($id);

        return response()->json($results);
    }

    /**
     * 显示公告信息
     * @return [type] [deception]
     */
    public function display()
    {
        $results = $this->service->displayNotice();

        return response()->json($results);
    }
}