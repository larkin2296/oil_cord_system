<?php
namespace App\Services\Api;

use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\EncryptTrait;
use App\Traits\ServiceTrait;
use App\Traits\UserTrait;
use App\Traits\CodeTrait;
use App\Services\Service;
use Exception;
use DB;
use App\Repositories\Models\User;
use App\Traits\CatSupplyTrait;
use JWTAuth;
use phpDocumentor\Reflection\Types\Integer;
use Redis;
use Hashids\Hashids;
Class NoticeService extends Service{

    use ServiceTrait,
        ResultTrait,
        ExceptionTrait,
        CodeTrait,
        EncryptTrait,
        UserTrait,
        CatSupplyTrait;

    protected $builder;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 管理员公告列表
     * @return [type] [deception]
     */
    public function index()
    {
        try{
           $data = $this->noticeRepo->orderBy('created_at','desc')->all();
           if ($data->isNotEmpty()) {

           } else {
               throw new Exception('当前没有公告,请新增公告',2);
           }
        } catch(Exception $e){
            dd($e);
        }
        return ['code' => '200', 'message' => '公告列表显示成功', 'data' => $data];
    }

    /**
     * 新增公告
     * @return [type] [deception]
     */
    public function addNotice()
    {
       try{
           $exception = DB::transaction(function(){
                /*公告权限验证*/
               $results = $this->checkNoticeAdminJurisdiction();

               $user = $this->jwtUser();

               $data = [
                 'user_id' => $user->id,
                 'content' => request()->post('content',''),
               ];

               if($this->noticeRepo->create($data)) {
               } else {
                   throw new Exception('新增公告失败',getCommonCheckValue(false));
               }
               return $this->results = array_merge([
                  'code' => '200',
                  'message' => '新增成功',
                  'data' => collect(),
               ]);
           });
       } catch(Exception $e){
           dd($e);
       }
       return array_merge($this->results,$exception);
    }

    /**
     * 修改公告
     * @return [type] [deception]
     */
    public function updateNotice()
    {
        try{
            $exception = DB::transaction(function() {
                /*公告权限验证*/
                $results = $this->checkNoticeAdminJurisdiction();

                $user = $this->jwtUser();

                $data = [
                    'user_id' => $user->id,
                    'content' => request()->post('content',''),
                ];

                if($this->noticeRepo->update($data,request('id'))) {
                } else {
                    throw new Exception('修改公告失败',getCommonCheckValue(false));
                }
                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '修改成功',
                    'data' => collect(),
                ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 选择展示公告
     * @return [type] [deception]
     */
    public function choiceNotice()
    {
        try{
            $exception = DB::transaction(function() {
                /*公告权限验证*/
                $results = $this->checkNoticeAdminJurisdiction();

                $choice = ['choice' => getCommonCheckValue(true)];

                $folte = $this->noticeRepo->findWhere($choice);
                if($folte->isNotEmpty()) {
                    $folte->first()->choice = getCommonCheckValue(false);
                    $folte->save();
                }

                if ($this->noticeRepo->update($choice,request('id'))) {
                } else {
                    throw new Exception('选择公告失败',getCommonCheckValue(false));
                }

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '修改成功',
                    'data' => collect(),
                ]);

            });

        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 删除公告
     * @return [type] [deception]
     */
    public function destroyNotice($id)
    {
        try{
            $exception = DB::transaction(function() use ($id){
                /*公告权限验证*/
                $results = $this->checkNoticeAdminJurisdiction();

                if ($this->noticeRepo->delete($id)) {
                } else {
                    throw new Exception('删除公告失败',2);
                }

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '删除成功',
                    'data' => collect(),
                ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 展示公告
     * @return [type] [deception]
     */
    public function displayNotice()
    {
        try{
            $exception = DB::transaction(function() {
                $notice = $this->noticeRepo->findWhere(['choice' => getCommonCheckValue(true)])
                    ->map(function($item, $key){
                        return [
                            'content' => $item->content,
                            'timed' => $item->created_at->format('Y-m-d H:i'),
                        ];
                });
                if($notice->isNotEmpty()) {
                } else {
                    throw new Exception('当前没有公告展示',2);
                }

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '展示成功',
                    'data' => $notice,
                ]);
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

}