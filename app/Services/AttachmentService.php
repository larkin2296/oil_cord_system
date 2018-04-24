<?php
namespace App\Services;

use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\UserTrait;
use Exception;
use DB;
use Storage;

Class AttachmentService extends Service{

    use ResultTrait, ExceptionTrait, UserTrait;

    protected $disk = 'local';

    /**
     *上传附件
     * @return [type] [description]
     */
    public function upload()
    {
        $exception = DB::transaction(function(){

            if( !request()->hasFile('cam_file') ) {
               throw new Exception('文件不能空',2);
            }
            $file = request()->file('cam_file','');

            /*上传文件路径*/
            $path = $file->store('attachments',$this->disk);

            /*用户信息*/
            $user = $this->jwtUser();

            /*文件信息*/
            $fileName = $file->hashName();
            $data = [
                'name' => $fileName,
                'origin_name' => $file-> getClientOriginalName(),
                'size' => $file->getClientSize(),
                'path' => $path,
                'ext' => $file->getClientOriginalExtension(),
                'ext_info' => '',
                'supply_id' => '',
            ];
            if( $attachment = $this->attachmentRepo->create($data) ){

                  $this->results = array_merge($this->results,[
                    'id' => $attachment->id,
                    'name' => $attachment->name,
                    'ext' => $attachment->ext,
                    'size' => $attachment->size,
                    'url' => '',
                    'created_at' => $this->created_at->formate('Y-m-d H:i:s'),
                ]);

            } else {
                throw new EXception('附件上传失败',2);
            }
            return array_merge($this->results,['code' => 200]);

        });

        return array_merge($this->results,$exception);

    }

    /**
     * 查看附件
     * return [type] [description]
     */
    public function uploadList($id)
    {
        /*检测文件是否存在*/
    }

}