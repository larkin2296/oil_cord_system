<?php
namespace App\Services\Api;
use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;
use App\Traits\ServiceTrait;
use App\Traits\CodeTrait;
use App\Traits\UserTrait;
use App\Services\Service;
use App\Traits\CatSupplyTrait;
use Exception;
use DB;
use Redis;
use App\User;
use JWTAuth;
class ConfigureService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait,UserTrait,CatSupplyTrait;
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

    public function save_platform_discount() {
        try{
            $exception = DB::transaction(function(){
                $id = request()->post('id','');
                $recharge = request()->post('camilo_recharge','');
                $sell = request()->post('camilo_sell','');

                if($id != ''){
                    $data = $this->platformRepo->update(['camilo_recharge'=>$recharge,'camilo_sell'=>$sell],$id);

                    if($data) {
                        return ['code' => 200, 'message' => '修改成功', 'data' => $data];
                    } else {
                        return ['code' => 300, 'message' => '修改失败', 'data' => ''];
                    }
                } else {
                    return ['code' => 300, 'message' => '修改失败', 'data' => ''];
                }
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }

    public function get_discount_data() {
        $price = request()->post('card_price','');
        $platform = request()->post('goods_type','');
        $platform_money_id = $this->platformMoneyRepo->findWhere(['denomination'=>$price])->map(function($item,$key){
            return [
                'id'=>$item['id']
            ];
        })->first();

        $platform_id = $this->platformRepo->findWhere(['platform_name'=>$platform])->map(function($item,$key){
            return [
                'id'=>$item['id']
            ];
        })->first();

        if($result = $this->discountRepo->findWhere(['platform_id'=>$platform_id['id'],'denomination_id'=>$platform_money_id['id']])->first()){
            $arr[] = [
                'platform_name' => $platform,
                'platform_id' => $platform_id['id'],
                'denomination' => $price,
                'denomination_id' => $platform_money_id['id'],
                'camilo_recharge' => $result['camilo_recharge'],
                'camilo_sell' => $result['camilo_sell'],
                'edit' => false,
                'edit1' => false
            ];
        } else {
        $result = $this->platformRepo->find($platform_id)->first();
            $arr[] = [
                'platform_name' => $platform,
                'platform_id' => $platform_id['id'],
                'denomination' => $price,
                'denomination_id' => $platform_money_id['id'],
                'camilo_recharge' => $result['camilo_recharge'],
                'camilo_sell' => $result['camilo_sell'],
                'edit' => false,
                'edit1' => false
            ];
        }
        return ['code' => 200, 'message' => '查询成功', 'data' => $arr];
    }

    public function save_discount_data() {
        try{
            $exception = DB::transaction(function(){
                $denomination_id = request()->post('denomination_id','');
                $platform_id = request()->post('platform_id','');
                $camilo_recharge = request()->post('camilo_recharge','');
                $camilo_sell = request()->post('camilo_sell','');

                $arr = [
                    'camilo_recharge' => $camilo_recharge,
                    'camilo_sell' => $camilo_sell,
                ];
                $result = $this->discountRepo->updateOrCreate(['platform_id'=>$platform_id,'denomination_id'=>$denomination_id],$arr);
                return ['code' => 200, 'message' => '修改成功', 'data' => $result];
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }

    public function set_config_status() {
        try{
            $exception = DB::transaction(function(){
                $type = request()->post('type','');
                $id = request()->post('id','');
                $status = request()->post('status','');

                if($type == 'good') {
                    $result = $this->platformRepo->update(['status'=>$status],$id);
                } else {
                    $result = $this->platformMoneyRepo->update(['status'=>$status],$id);
                }
                return ['code' => '200', 'message' => '修改成功', 'data' => $result];
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }

    public function get_inventory() {
        try{
            $exception = DB::transaction(function(){
                $price = request()->post('card_price','');
                $platform = request()->post('goods_type','');
                $where = [];
                if($price != ''){
                    $platform_money_id = $this->platformMoneyRepo->findWhere(['denomination'=>$price])->map(function($item,$key){
                        return [
                            'id'=>$item['id']
                        ];
                    })->first();

                    $where['denomination_id'] = $platform_money_id['id'];
                }

                if($price != ''){
                    $platform_id = $this->platformRepo->findWhere(['platform_name'=>$platform])->map(function($item,$key){
                        return [
                            'id'=>$item['id']
                        ];
                    })->first();
                    $where['platform_id'] = $platform_id['id'];
                }


                $data =  $this->inventoryRepo->findWhere($where)->map(function($item,$key){
                    return [
                        'denomination' => $this->handleDenomination($item['denomination_id']),
                        'platform_name' => $this->handlePlatform($item['platform_id']),
                        'num' => $item['num'],
                        'vaild_num' => $item['vaild_num'],
                        'invalid_num' => $item['invalid_num']
                    ];
                });
                return ['code' => 200, 'message' => '查询成功', 'data' => $data];
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }

    public function get_inventory_status() {
        try{
            $exception = DB::transaction(function(){
                $price = request()->post('card_price','');
                $platform = request()->post('goods_type','');
                $where = [];
                if($price != ''){
                    $platform_money_id = $this->platformMoneyRepo->findWhere(['denomination'=>$price])->map(function($item,$key){
                        return [
                            'id'=>$item['id']
                        ];
                    })->first();

                    $where['denomination_id'] = $platform_money_id['id'];
                }

                if($price != ''){
                    $platform_id = $this->platformRepo->findWhere(['platform_name'=>$platform])->map(function($item,$key){
                        return [
                            'id'=>$item['id']
                        ];
                    })->first();
                    $where['platform_id'] = $platform_id['id'];
                }

                if($data = $this->inventoryRepo->findWhere($where)->pluck('vaild_num')){
                    if($data == []){
                        $data = null;
                    }
                    return ['code' => 200, 'message' => '查询成功', 'data' => $data];
                }else{
                    return ['code' => 400, 'message' => '查询成功', 'data' => $data];
                }
            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }
}