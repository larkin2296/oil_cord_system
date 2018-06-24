<?php

namespace App\Services;


use App\Repositories\Interfaces\PurchasingOrderRepository;
use App\Repositories\Interfaces\UserRepository;
use App\Repositories\Interfaces\UserOilCardRepository;
use App\Repositories\Interfaces\AttachmentRepository;
use App\Repositories\Interfaces\PlatformRepository;
use App\Repositories\Interfaces\PlatformMoneyRepository;
use App\Repositories\Interfaces\RelationPlatformRepository;
use App\Repositories\Interfaces\SupplyCamRepository;
use App\Repositories\Interfaces\SupplySingleRepository;
use App\Repositories\Interfaces\PurchasingCamiloDetailRepository;
use App\Repositories\Interfaces\OilSupplyRepository;
use App\Repositories\Interfaces\ForwardRepository;
use App\Repositories\Interfaces\PresentForwardRepository;
use App\Repositories\Interfaces\PresentSettingRepository;
use App\Repositories\Interfaces\PurchasingPerrmissonRepository;
use App\Repositories\Interfaces\AuditRepository;
use App\Repositories\Interfaces\UserAttachmentRepository;
use App\Repositories\Interfaces\InitializeRepository;

use App\Repositories\Interfaces\JurisdictionRepository;

use App\Repositories\Interfaces\ConfigureRepository;
use App\Repositories\Interfaces\ReconciliationRepository;
use App\Repositories\Interfaces\DiscountRepository;
use App\Repositories\Interfaces\InventoryRepository;




class Service
{
    public $userRepo;
    public $purorderRepo;
    public $purperrmissonRepo;
    public $oilcardRepo;
    public $attachmentRepo;
    public $userAttachmentRepo;
    public $platformRepo;
    public $platformMoneyRepo;

    public $relationPlatformRepo;
    public $supplyCamRepo;
    public $supplySingleRepo;

    public $auditRepo;
    public $purchasingcamilodetailRepo;
    public $oilSupplyRepo;
    public $forwardRepo;
    public $presentForwardRepo;
    public $presentSettingRepo;
    public $initializeRepo;

    public $jurisdictionRepo;
    public $configureRepo;
    public $reconRepo;
    public $discountRepo;
    public $inventoryRepo;





    public function __construct()
    {
        $this->userRepo = app(UserRepository::class);
        $this->purorderRepo = app(PurchasingOrderRepository::class);
        $this->oilcardRepo = app(UserOilCardRepository::class);
        $this->attachmentRepo = app(AttachmentRepository::class);
        $this->platformRepo = app(PlatformRepository::class);
        $this->platformMoneyRepo = app(PlatformMoneyRepository::class);

        $this->relationPlatformRepo = app(RelationPlatformRepository::class);
        $this->supplyCamRepo = app(SupplyCamRepository::class);
        $this->supplySingleRepo = app(SupplySingleRepository::class);

        $this->purchasingcamilodetailRepo = app(PurchasingCamiloDetailRepository::class);
        $this->purperrmissonRepo = app (PurchasingPerrmissonRepository::class);
        $this->oilSupplyRepo = app(OilSupplyRepository::class);
        $this->forwardRepo = app(ForwardRepository::class);
        $this->presentForwardRepo = app(PresentForwardRepository::class);
        $this->presentSettingRepo = app(PresentSettingRepository::class);
        $this->auditRepo = app(AuditRepository::class);
        $this->userAttachmentRepo = app(UserAttachmentRepository::class);
        $this->initializeRepo = app(InitializeRepository::class);

        $this->jurisdictionRepo = app(JurisdictionRepository::class);

        $this->configureRepo = app(ConfigureRepository::class);

        $this->reconRepo = app(ReconciliationRepository::class);
        $this->discountRepo = app(DiscountRepository::class);
        $this->inventoryRepo = app(InventoryRepository::class);


    }
}