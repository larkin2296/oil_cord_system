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
use function Sodium\increment;

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

                /*验证权限*/
                $this->checkSupplyAdminJurisdiction();

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

                    if(request()->post('goods_type','')){
                        $where['platform_id'] = $this->get_platform_id(request()->post('goods_type',''));
                    }
                    if(request()->post('card_price','')){
                        $where['denomination'] = $this->get_denomination_id(request()->post('card_price',''));
                    }

                    if (request()->post('is_del','')) {
//                         $where['is_del'] = request()->post('is_del','');
                    } else {
                        $where['deleted_at'] = null;
                    }

                $data = $this->supplyCamRepo->model()::where($where)
                    ->orderBy('created_at','desc')
                    ->withTrashed()
                    ->get()
                    ->map(function($item, $key) {
                        return [
                            'id' => $item->id,
                            'user_id' => $item->user_id,
                            'userName' => $this->getIdUserInfo($item->user_id)->truename ?? $this->getIdUserInfo($item->user_id)->mobile ,
                            'cam_name' => $item->cam_name,
                            'cam_other_name' => $item->cam_other_name,
                            'platform_id' => $this->handlePlatform($item->platform_id)['platform_name'],
                            'denomination' => $this->handleDenomination($item->denomination)['denomination'],
                            'success_time' => $item->success_time,
                            'created_at' => $item->created_at->format('Y-m-d H:i'),
                            'discount' => $item->discount,
                            'status' => $this->checkCamStatus($item->status),
                            'deleted_at' => $item->deleted_at
                            ];
                    });

                if ($data) {
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

                /*验证权限*/
                $this->checkSupplyAdminJurisdiction();

                $this->inventory_del(request()->id);
                if (!$data = $this->supplyCamRepo->delete(request()->id)) {
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

                /*验证权限*/
                $this->checkSupplyAdminJurisdiction();
                if (!$data = $this->supplyCamRepo->model()::withTrashed()->where('id',request()->id)->restore()) {
                    throw new Exception('恢复卡密失败',2);
                }else{
                    $this->inventory_add(request()->id);
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
//        return array_merge($this->results,$exception);
    }


    /**
     *代充管理列表
     * return [type] [deception]
     */
    public function show()
    {
        try{
            $exception = DB::transaction(function() {
                $this->checkSupplyAdminJurisdiction();
                /*用户信息*/
                $user = $this->jwtUser();

                $field = [
                    'user_id' => '=',
                    'supply_single_number' => 'like',
                    'oil_number' => '=',
                    'end_time' => 'like',
                    'supply_status' => '=',
                ];

                $where = $this->searchArray($field);

                $data =  $this->supplySingleRepo->orderBy('supply_status','desc')->findWhere($where)
                    ->map(function($item, $key){
                        return [
                            'id' => $item->id,
                            'userName' => $this->getIdUserInfo($item->user_id)->truename ?? $this->getIdUserInfo($item->user_id)->mobile ,
                            'oil_number' => $item->oil_number,
                            'already_card' => $item->already_card,
                            'end_time' => $item->end_time,
                            'notes' => $item->notes,
                            'status' => $this->globalStatusGet($item->status),
                            'supply_status' => $this->checkSupplyStatus($item->supply_status),
                            'forward_status' => $this->checkForWardStatus($item->forward_status),
                            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                            'discount' => $item->discount,
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

    public function set_account() {
        $post = request()->post('list','');
        $id = $post['id'];
        $card = $post['card'];
        $money = $post['money'];
        $res = $this->supplySingleRepo->update(['supply_status' => 1],$id);
        $singe_money = $this->oilcardRepo->findWhere(['oil_card_code'=>$card]);
        $already_money = $singe_money[0]['save_money'] + $money;
        $total_money = $singe_money[0]['total_money'] + $money;
        $data = $this->oilcardRepo->model()::where(['oil_card_code'=>$card])->update(['save_money'=>$already_money,'total_money'=>$total_money]);
        if($res) {
            return $this->results = array_merge([
                'code' => '200',
                'message' => '设置成功',
                'data' => $res,
            ]);
        } else {
            return $this->results = array_merge([
                'code' => '400',
                'message' => '设置失败',
                'data' => $res,
            ]);
        }
    }
    public function inventory_add($id){
        $data = $this->supplyCamRepo->find($id);
        $this->inventoryRepo->updateOrCreate(['platform_id'=>$data->platform_id,'denomination_id'=>$data->denomination])->increment('vaild_num');
    }
    public function inventory_del($id){
        $data = $this->supplyCamRepo->find($id);
        $this->inventoryRepo->updateOrCreate(['platform_id'=>$data->platform_id,'denomination_id'=>$data->denomination])->increment('vaild_num',-1);
    }
}