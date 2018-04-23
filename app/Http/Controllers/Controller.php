<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct() {
        header("Access-Control-Allow-Origin: *");
        header('content-type:application/json;charset=utf8');
        header('Access-Control-Allow-Credentials', 'true');
        header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
        header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept');

    }
    public function upfile(Request $request) {
        if (!$request->hasFile('file')) {
            return response()->json([], 500, '无法获取上传文件');
        }
        $file = $request->file('file');

        if ($file->isValid()) {
            $originalName = $file->getClientOriginalName();
            //扩展名
            $ext = $file->getClientOriginalExtension();
            //文件类型
            $type = $file->getClientMimeType();
            //临时绝对路径
            $realPath = $file->getRealPath();
            //重新设置文件名
            $filename = date('Y-m-d-H-i-S').'-'.uniqid().'.'.$ext;
            //文件存储
            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'name' => $filename,
            ]);

        } else {
            return response()->json([], 500, '文件未通过验证');
        }
    }
}
