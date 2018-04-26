<?php

namespace App\Traits;
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


}