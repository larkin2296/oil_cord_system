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
class AdministratorService extends Service {
    use ServiceTrait,ResultTrait,ExceptionTrait, CodeTrait,UserTrait,CatSupplyTrait;
    protected $builder;
    public function __construct()
    {
        parent::__construct();
    }
    public function get_camilo_list(){
        try{
            $exception = DB::transaction(function(){

                /*用户信息*/
                $user = $this->jwtUser();

                $field= [
                    'order_type' => '='
                ];
                $fieldWhere =  $this->searchArray($field);

                $where = array_merge($fieldWhere,[
                    'order_type' => 1,
                ]);

                $data =  $this->purorderRepo->findWhere($where)->map(function($item,$key){
                    //return $item;
                    return [
                        'id' => $item['id'],
                        'order_code' => $item['order_code'],
                        'discount' => $item['discount'],
                        'denomination' => $this->handleDenomination($item['unit_price']),
                        'platform_id' => $this->handlePlatform($item['platform']),
                        'created_at' => $item['created_at'],
                        'num' => $item['num'],
                        'status' => $item['order_status']
                    ];

                })->all();
                //->model()::with(['denomination','platform'])->get();
                if( $data ) {
                } else {
                    throw new EXception('卡密查询异常,请重试','2');
                }
                return ['code' => '200', 'message' => '查询成功', 'data' => $data];

            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }

    public function send_camilo(){
        try{
            $exception = DB::transaction(function(){

                $post = request()->post('list','');
                $platform_id = $post['platform_id']['id'];
                $denomination = $post['denomination']['id'];
                $order = $post['id'];
                /*用户信息*/
                $user = $this->jwtUser();

                $field= [
                    'platform_id' => '=',
                    'denomination' => '=',
                    'status' => '=',
                ];
                $fieldWhere =  $this->searchArray($field);

                $where = array_merge($fieldWhere,[
                    'platform_id' => $platform_id,
                    'denomination' => $denomination,
                    'status' => 1
                ]);

                $data =  $this->supplyCamRepo->model()::where($where)->limit($post['num'])->get()->map(function($item,$key){
                    //return $item;
                    return [
                        'id' => $item['id'],
                    ];

                })->all();
                if(sizeof($data) < $post['num']){
                    return ['code' => '400', 'message' => '卡密数量不够', 'data' => ''];
                } else {
                    try{
                        $this->set_camilo_status($data);
                    }catch(Exception $e){
                        return ['code' => '400', 'message' => $e, 'data' => ''];
                    }
                    try{
                        $this->set_camilo_order($data,$order);
                    }catch(Exception $e){
                        return ['code' => '400', 'message' => $e, 'data' => ''];
                    }
                }
                if( $data ) {
                } else {
                    throw new EXception('卡密查询异常,请重试','2');
                }
                return ['code' => '200', 'message' => '查询成功', 'data' => $data];

            });
        } catch(Exception $e){
            dd($e);
        }
        return array_merge($this->results, $exception);
    }
    private function set_camilo_status($data){
        foreach($data as $value){
            $this->supplyCamRepo->update(['status'=>2],$value['id']);
        }
        return true;
    }
    private function set_camilo_order($data,$order){
        foreach($data as $value){
            $this->purchasingcamilodetailRepo->create(['order_code'=>$order,'camilo_id'=>$value['id']]);
        }
        $this->purorderRepo->update(['order_status'=>2],$order);
        return true;
    }
}