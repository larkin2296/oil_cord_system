<?php

namespace App\Services;


use App\Repositories\Interfaces\PurchasingOrderRepository;
use App\Repositories\Interfaces\UserRepository;
use App\Repositories\Interfaces\UserOilCardRepository;
use App\Repositories\Interfaces\AttachmentRepository;
use App\Repositories\Interfaces\PlatformRepository;
use App\Repositories\Interfaces\PlatformMoneyRepository;
use App\Repositories\Interfaces\RelationPlatformRepository;
<<<<<<< HEAD
use App\Repositories\Interfaces\SupplyCamRepository;
use App\Repositories\Interfaces\SupplySingleRepository;

=======
use App\Repositories\Interfaces\PurchasingCamiloDetailRepository;
use App\Repositories\Models\PurchasingCamiloDetail;
>>>>>>> 95e0c91cdeac857f422b750f4a9bc6acb0c689b1


class Service
{
    public $userRepo;
    public $purorderRepo;
    public $oilcardRepo;
    public $attachmentRepo;
    public $platformRepo;
    public $platformMoneyRepo;
<<<<<<< HEAD
    public $relationPlatformRepo;
    public $supplyCamRepo;
    public $supplySingleRepo;
=======
    public $RelationPlatformRepo;
    public $purchasingcamilodetailRepo;

>>>>>>> 95e0c91cdeac857f422b750f4a9bc6acb0c689b1


    public function __construct()
    {
        $this->userRepo = app(UserRepository::class);
        $this->purorderRepo = app(PurchasingOrderRepository::class);
        $this->oilcardRepo = app(UserOilCardRepository::class);
        $this->attachmentRepo = app(AttachmentRepository::class);
        $this->platformRepo = app(PlatformRepository::class);
        $this->platformMoneyRepo = app(PlatformMoneyRepository::class);
<<<<<<< HEAD
        $this->relationPlatformRepo = app(RelationPlatformRepository::class);
        $this->supplyCamRepo = app(SupplyCamRepository::class);
        $this->supplySingleRepo = app(SupplySingleRepository::class);
=======
        $this->RelationPlatformRepo = app(RelationPlatformRepository::class);
        $this->purchasingcamilodetailRepo = app(PurchasingCamiloDetailRepository::class);
>>>>>>> 95e0c91cdeac857f422b750f4a9bc6acb0c689b1
    }
}