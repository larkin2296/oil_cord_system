<?php

namespace App\Services;


use App\Repositories\Interfaces\PurchasingOrderRepository;
use App\Repositories\Interfaces\UserRepository;
use App\Repositories\Interfaces\UserOilCardRepository;



class Service
{
    public $userRepo;
    public $purorderRepo;
    public $oilcardRepo;


    public function __construct()
    {
        $this->userRepo = app(UserRepository::class);
        $this->purorderRepo = app(PurchasingOrderRepository::class);
        $this->oilcardRepo = app(UserOilCardRepository::class);
    }
}