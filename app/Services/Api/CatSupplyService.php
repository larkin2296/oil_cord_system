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

Class CatSupplyservice extends Service{
    protected $build;
    use ResultTrait, ExceptionTrait, ServiceTrait, CodeTrait,UserTrait;

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
        dd(123);
    }


    /**
     * 平台金额
     * return [type][deception]
     */
    public function show()
    {
        dd(123);
    }

}
