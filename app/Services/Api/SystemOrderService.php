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

class SystemOrderService extends Service
{
    use ServiceTrait, ResultTrait, ExceptionTrait, CodeTrait, EncryptTrait, UserTrait, CatSupplyTrait;

    protected $builder;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 卡密管理
     * @return [type] [description]
     */
    public function index()
    {
        try {
            $exception = DB::transaction(function () {

                /*用户信息*/
                $user = $this->jwtUser();

                if($user->role_status != 3) {
                    throw new Exception('您没有管理员权限,请联系管理员',2);
                }

                $field = [
                   'platform_id' => '=',
                   'denomination' => '=',
                   'success_time' => 'like',
                   'cam_name' => 'like',
                   'cam_other_name' => 'like',
                   'status' => '=',
                ];
                /*处理查询*/
                $where = $this->searchArray($field);

                $data = $this->supplyCamRepo->findWhere($where)
                    ->map(function($item, $key){

                    return [
                        'id' => $item->id,
                        'user_id' => $item->user_id,
                        'userName' => $this->getIdUserInfo($item->user_id)->truename ?? $this->getIdUserInfo($item->user_id)->mobile ,
                        'cam_name' => $item->cam_name,
                        'cam_other_name' => $item->cam_other_name,
                        'platform_id' => $this->handlePlatform($item->platform_id)['platform_name'],
                        'denomination' => $this->handleDenomination($item->denomination)['denomination'],
                        'success_time' => $item->success_time,
                        'discount' => $item->discount,
                        'status' => $this->checkCamStatus($item->status),

                    ];
                })->all();

                if ( $data ) {
                } else {
                    throw new Exception("数据查询失败", 2);
                }
                return $this->results = array_merge([
                   'code' => '200',
                   'message' => '卡密列表显示成功',
                   'data' => $data,
                ]);
            });
        } catch (Exception $e) {
            dd($e);

        }
        return array_merge($this->results, $exception);

    }

    /**
     * 删除卡密
     * return [type] [deception]
     */
    public function destroy()
    {
        try{
            $exception = DB::transaction(function() {

                /*验证管理员*/
                $isAdmin =  $this->checkAdminUser();

                if( $data = $this->supplyCamRepo->delete(request()->id) ) {

                } else {
                    throw new Exception('删除卡密失败',2);
                }

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '删除成功',
                    'data' => $data,
                ]);
            });

        } catch(Exception $e ) {
            dd($e);
        }
        return array_merge($this->results,$exception);
    }

    /**
     * 恢复卡密
     * return [type] [deception]
     */
    public function recover()
    {
        try{
            $exception = DB::transaction(function() {

                /*验证管理员*/
                $isAdmin =  $this->checkAdminUser();

                if( $data = $this->supplyCamRepo->model()::withTrashed()->where('id',request()->id)->restore() ) {

                } else {
                    throw new Exception('恢复卡密失败',2);
                }

                return $this->results = array_merge([
                    'code' => '200',
                    'message' => '恢复成功',
                    'data' => $data,
                ]);
            });

        } catch(Exception $e ) {
            dd($e);
        }
        return array_merge($this->results,$exception);
    }


    /**
     *代充管理列表
     * return [type] [deception]
     */
    public function show()
    {
        try{
            $exception = DB::transaction(function() {
                /*用户信息*/
                $user = $this->jwtUser();

                if($user->role_status != 3) {
                    throw new Exception('您没有管理员权限,请联系管理员',2);
                }
                #TODO 这里写个获取所有供应商的公共接口

                $field = [
                    'user_id' => '=',
                    'supply_single_number' => 'like',
                    'oil_number' => '=',
                    'end_time' => 'like',
                    'status' => '=',
                ];

               $where = $this->searchArray($field);

               $data =  $this->supplySingleRepo->findWhere($where)
                   ->map(function($item, $key){
                    return [
                        'id' => $item->id,
                        'oil_number' => $item->oil_number,
                        'already_card' => $item->already_card,
                        'end_time' => $item->end_time,
                        'notes' => $item->notes,
                        'status' => $this->globalStatusGet($item->status),
                        'supply_status' => $this->checkSupplyStatus($item->supply_status),
                        'forward_status' => $this->checkForWardStatus($item->forward_status),
                        'direct_id' => route('common.attach.show', [$item->direct_id]),
                    ];
                    })->all();

                    return $this->results = array_merge([
                    'code' => '200',
                    'message' => '代充列表显示成功',
                    'data' => $data,
                ]);

            });

        } catch(Exception $e){
            dd($e);
        }

        return array_merge($this->results,$exception);
    }

}