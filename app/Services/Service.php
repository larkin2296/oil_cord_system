<?php

namespace App\Services;


use App\Repositories\Interfaces\PurchasingOrderRepository;
use App\Repositories\Interfaces\UserRepository;
use App\Repositories\Interfaces\UserOilCardRepository;
use App\Repositories\Interfaces\AttachmentRepository;
use App\Repositories\Interfaces\PlatformRepository;
use App\Repositories\Interfaces\PlatformMoneyRepository;
use App\Repositories\Interfaces\RelationPlatformRepository;



class Service
{
    public $userRepo;
    public $purorderRepo;
    public $oilcardRepo;
    public $attachmentRepo;
    public $platformRepo;
    public $platformMoneyRepo;
    public $RelationPlatformRepo;



    public function __construct()
    {
        $this->userRepo = app(UserRepository::class);
        $this->purorderRepo = app(PurchasingOrderRepository::class);
        $this->oilcardRepo = app(UserOilCardRepository::class);
        $this->attachmentRepo = app(AttachmentRepository::class);
        $this->platformRepo = app(PlatformRepository::class);
        $this->platformMoneyRepo = app(PlatformMoneyRepository::class);
        $this->RelationPlatformRepo = app(RelationPlatformRepository::class);
    }
}