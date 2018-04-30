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
use Carbon\Carbon;

Class CatSupplyservice extends Service{
    protected $build;
    use ResultTrait, ExceptionTrait, ServiceTrait, CodeTrait, UserTrait,CatSupplyTrait;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 卡密供货
     * return [type][deception]
     */
    public function create()
    {
        try{
            $exception = DB::transaction( function() {

                $now = new Carbon();

                /*面额*/
                $platform_money_id = request()->post('money_id','');

                /*平台*/
                $platform_id = request()->post('platform_id','');

                #TODO 供应单号表  卡密表
                $cam = request()->post('cam',[]);

                $cam_random = request()->post('cam_two',[]);


                // 生成关联关系  绑定数据关系
                //supply_single_number
                //一个供应单表对应一条 金额 平台 对应多条卡密 对应一条附件信息
                /*用户信息*/
                $user = $this->jwtUser();

                $arr = [
                  'user_id' => $user->id,
                  'commodity_name' => $this->platformRepo->find($platform_id)->platform_name,
                  'denomination' => $this->platformMoneyRepo->find($platform_money_id)->denomination,
                  'status' => 1,
                ];
                /*供应单*/
                $supply =  $this->supplySingleRepo->create($arr);

                $supply_id = $supply->id;

                /*供应单号*/
                $supplySingleNumber = $this->generateSupplyNumber($supply,$user);

                $this->supplySingleRepo->update(['supply_single_number' => $supplySingleNumber],$supply_id);

                /*卡密信息*/
                foreach( $cam as $item ) {

                    $this->supplyCamRepo->create([
                        'cam_name' => $item,
                        'supply_id' => $supply_id,
                    ]);

                }


                /*面额平台*/
                $this->relationPlatformRepo->create([
                        'supply_id' => $supply_id,
                        'platform_id' => $platform_id,
                        'money_id' => $platform_money_id,
                    ]
                );

                return ['code' => 200, 'message' => '显示成功', 'data' => ''];

            });

        }catch(EXception $exception){

        }
        return array_merge($this->results,$exception);
    }


    /**
     * 平台金额
     * return [type][deception]
     */
    public function show()
    {
        try{
            $exception = DB::transaction(function(){
                /*获取平台*/
                $platform = $this->platformRepo->all();

                /*获取面额*/
                $platformMoney = $this->platformMoneyRepo->all();

                $data = [
                    'platform' => $platform->toArray() ?? '',
                    'money' => $platformMoney->toArray() ?? '',
                ];
                return ['code' => 200, 'message' => '显示成功', 'data' => $data];

            });
        } catch(Exception $e){

        }
        return array_merge($this->results,$exception);

    }

}
