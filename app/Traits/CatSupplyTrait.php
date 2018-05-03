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
}