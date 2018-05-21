<?php
namespace App\Services;

use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\UserTrait;
use App\Traits\DataTrait;
use Exception;
use DB;
use Storage;

Class AttachmentService extends Service{

    use ResultTrait, ExceptionTrait, UserTrait, DataTrait;

    protected $disk = 'local';



        /**
         *上传附件
         * @return [type] [description]
         */
    public function upload()
    {
        $exception = DB::transaction(function() {

            if( !request()->hasFile('file') ) {
                throw new Exception('文件不能空',2);
            }

            $file = request()->file('file','');

            /*上传文件路径*/
            $path = $file->store('attachments',$this->disk);

            /*用户信息*/
            $user = $this->userByJwt();

            /*文件信息*/
            $fileName = $file->hashName();

            $data = [
                'name' => $fileName,
                'origin_name' => $file-> getClientOriginalName(),
                'size' => $file->getClientSize(),
                'path' => $path,
                'ext' => $file->getClientOriginalExtension(),
                'ext_info' => '',
                'status' => request()->post('status',''),
                'user_id' => $user->id,
            ];

            if( $attachment = $this->attachmentRepo->create($data) ){

                $this->results = array_merge($this->results,[
                    'data' => [
                    'id_hash' => $attachment->id,
                    'name' => str_replace('.' .$attachment->ext ,'',$attachment->origin_name),
                    'ext' => $attachment->ext,
                    'size' => $attachment->size,
                    'url' => route('common.attach.show', [$attachment->id]),
                    'created_at' => $attachment->created_at->format('Y-m-d H:i:s'),
                    ],
                ]);
            } else {
                throw new EXception('附件上传失败',2);
            }

            return array_merge($this->results,[
                'code' => 200
            ]);

        });

        return array_merge($this->results,$exception);

    }

    /**
     * 查看附件
     * return [type] [description]
     */
    public function show($id)
    {
        try{
            /*检测文件是否存在*/
            $attachments = $this->attachmentRepo->find($id);
            if( Storage::disk($this->disk)->exists($attachments->path) ) {
                /* 获取文件 */
                $path =  Storage::disk($this->disk)->path($attachments->path);
                $name = $attachments->origin_name;
                return [
                    'path' => $path,
                    'name' => $name,
                ];
            } else {
                abort(404,'文件不存在');
            }

        } catch(Exception $e) {
            abort(404,'文件不存在');
        }
    }

    /**
     * 用户头像
     * return [type] [description]
     */
    public function avatar($id)
    {
        try{
            /*查看当前用户信息*/
            $user = $this->userRepo->find($id);
            if( Storage::disk($this->disk)->exists($user->avatar) ) {

                $path =  Storage::disk($this->disk)->exists($user->avatar);

                return $path;
            } else {
                abort(404,'没有头像');
            }
        } catch(Exception $e){
            abort(404,'用户没有头像');
        }

    }

}