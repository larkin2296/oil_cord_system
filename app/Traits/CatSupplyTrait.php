<?php

namespace App\Traits;
use App\Repositories\Interfaces\PlatformMoneyRepository;
use App\Repositories\Interfaces\PlatformRepository;
use App\Repositories\Models\PlatformMoney;
use PhpRedis;
use Exception;
use App\Traits\UserTrait;
Trait CatSupplyTrait{

    /**
     * 供应单号
     * return [type] [deception]
     */
    public function generateSupplyNumber($supply, $user, $serviceType = '1')
    {
        $businessType = '0';

        $user_id = $user->id;

        $supply_id = $supply->id;

        return $supply_id . $serviceType . $businessType . date('Ymd') . substr(time(), 2) . $user_id . rand(0, 9);
    }

    /**
     *面额关联
     *return [type] [deception]
     */
    public function handleDenomination($denomination)
    {
        return app(PlatformMoneyRepository::class)->find($denomination)->toArray();
    }

    /**
     *平台关联
     *return [type] [deception]
     */
    public function handlePlatform($platform)
    {
        return app(PlatformRepository::class)->find($platform)->toArray();
    }

    /**
     * 卡密提现状态
     * return [type] [data]
     */
    public function checkForWardStatus($status)
    {
        $data = [
           '1' => '已提现',
           '2' => '未提现',
           '3' => '提现中',

        ];
        return $data[$status];
    }
    /**
     * 成功失败状态
     * return [type] [deception]
     */
    public function globalStatusGet($status)
    {
        $data = [
            '1' => '成功',
            '2' => '失败',
        ];
        return $data[$status];
    }



    /**
     * 卡密状态
     * return [type] [deception]
     */
    public function checkCamStatus($status)
    {
        $item = [
            '1' => '上传成功',
            '2' => '下发采购商',
            '3' => '问题卡密',
            '4' => '销卡成功',
        ];
        return $item[$status];
    }

    /**
     * 直充订单状态
     * @param $status
     * @return mixed
     */
    public function checkSupplyStatus($status)
    {
        $item = [
            '1' => '已到账',
            '2' => '未到账',
            '3' => '问题订单',
        ];
        return $item[$status];
    }

    /**
     * 直充订单状态
     * @param $status
     * @return mixed
     */
    public function checkJurisdictionStatus($status)
    {
        $item = [
            '1' => '开启',
            '2' => '关闭',
        ];
        return $item[$status];
    }

    /**
     * 提现单号
     * return [type] [deception]
     */
    public function getForwardNumber($user,$serviceType = '1')
    {
        $user_id = $user->id;

        $businessType = '0';

        return $serviceType . $businessType . date("Ymd") .substr(time(),2) .$user_id . rand(0, 9);
    }

    /*处理折扣*/
    public function checkActualMoney($discount,$moneyIds)
    {
        try{
            $money = $this->platformMoneyRepo->find($moneyIds)->denomination;
            if( !$money ) {
                throw new Exception('参数错误,暂无数据',2);
            }
            $info = ($money * $discount);
            return $info;
        } catch(Exception $e){
            dd($e);
        }

    }
    /*直充实际金额*/
    public function checkChargeMoney($money,$discount = 1)
    {
        try{
            return $money * $discount;
        } catch(Exception $e){
            dd($e);
        }
    }


}