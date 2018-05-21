<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\UserTrait;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, UserTrait;
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
            $user = $this->jwtUser();
            //文件存储
            $path = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
            $data = [
                'name' => $filename,
                'origin_name' => $file-> getClientOriginalName(),
                'size' => $file->getClientSize(),
                'path' => $path,
                'ext' => $file->getClientOriginalExtension(),
                'ext_info' => '',
                'status' => request()->status,
                'user_id' => $user->id,
            ];

            if( $attachment = $this->attachmentRepo->create($data) ){

                $this->results = array_merge($this->results,[

                    'id' => $attachment->id,
                    'name' => str_replace('.' .$attachment->ext ,'',$attachment->origin_name),
                    'ext' => $attachment->ext,
                    'size' => $attachment->size,
                    'url' => route('api.attachement.cam.list', [$attachment->id]),
                    'created_at' => $attachment->created_at->format('Y-m-d H:i:s'),

                ]);

            } else {
                throw new EXception('附件上传失败',2);
            }
            return array_merge($this->results,[
                'code' => 200
            ]);

        } else {
            return response()->json([], 500, '文件未通过验证');
        }
    }
}
