<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AttachmentService as Service;
class AttachmentController extends Controller {

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     *上传附件
     * @return [type] [description]
     */
     public function upload()
     {

         $results = $this->service->upload();

         return response()->json($results);
     }

     /**
      * 查看附件
      * @return [type] [description]
      */
      public function show($id)
      {
           $results = $this->service->show($id);

           return response()->json($results);
      }

    /**
     * 下载附件
     * @return [type] [description]
     */
    public function download($id)
    {
        $results = $this->service->show($id);

        return response()->json($results);
    }


    /**
     * 查看头像
     * @return [type] [description]
     */
     public function avatar($id)
     {
          $results = $this->service->avatar($id);

          return response()->json($results);
     }
}