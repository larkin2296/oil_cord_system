<?php
namespace App\Services\Api;
use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Traits\UserTrait;
use App\Services\Service;
use Exception;
use DB;
use Redis;
use App\User;
use JWTAuth;
class ConfigureService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait,UserTrait;
    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }
    public function get_oil_card() {
        $post = request()->post('list','');
        $user = $this->jwtUser();
        $result = $this->oilcardRepo->findWhere(['user_id'=>$user->id])->map(function($item,$index){
           return [
             'oil_card_code' => $item['oil_card_code'],
             'id' => $item['id']
           ];
        });
        return ['code' => 200, 'message' => '获取油卡信息成功','data' => $result];
    }

    public function get_config_set() {
        try{
            $this->checkCommodityAdminJurisdiction();
            $exception = DB::transaction(function(){

                $data =  $this->configureRepo->find(1)->all();

                if( $data ) {
                } else {
                    throw new EXception('卡密查询异常,请重试','2');
                }
                return ['code' => '200', 'message' => '查询成功', 'data' => $data[0]];

            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }

    public function save_config() {
        try{
            $exception = DB::transaction(function(){
                $this->checkCommodityAdminJurisdiction();
                $post = request()->post('list','');

                $res = $this->configureRepo->updateOrCreate(['id'=>$post['id']],$post);

                return ['code' => 200, 'message' => '修改成功', 'data' => $res];

            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }

    public function get_permission() {
        try{
            $exception = DB::transaction(function(){
                $user = request()->post('id','');

                if($user != ''){
                    $data = $this->userRepo->find($user)->pluck('role_status');

                    if($data[0] == 3) {
                        $res = $this->jurisdictionRepo->findWhere(['user'=>$user])->map(function($item,$index){
                            return [
                                'supply_jurisdiction' => $item['supply_jurisdiction'],
                                'purchase_jurisdiction' => $item['purchase_jurisdiction'],
                                'service_jurisdiction' => $item['service_jurisdiction'],
                                'commodity_jurisdiction' => $item['commodity_jurisdiction']
                            ];
                        });

                        if($res) {
                            return ['code' => 200, 'message' => '查询成功', 'data' => $res];
                        } else {
                            $res = ['supply_jurisdiction' => 2,
                                'purchase_jurisdiction' => 2,
                                'service_jurisdiction' => 2,
                                'commodity_jurisdiction' => 2];
                            return ['code' => 200, 'message' => '查询成功', 'data' => $res];
                        }
                    } else {
                        return ['code' => 300, 'message' => '查询成功', 'data' => ''];
                    }
                } else {
                    return ['code' => 300, 'message' => '查询成功', 'data' => ''];
                }
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }
}