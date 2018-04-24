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
        public function uploadList($id)
        {
            $results = $this->service->uploadList($id);

            return response()->json($results);
        }
}