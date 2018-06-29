<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(\App\Repositories\Interfaces\UserRepository::class, \App\Repositories\Eloquents\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\PurchasingOrderRepository::class, \App\Repositories\Eloquents\PurchasingOrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\UserOilCardRepository::class, \App\Repositories\Eloquents\UserOilCardRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\AttachmentRepository::class, \App\Repositories\Eloquents\AttachmentRepositoryEloquent::class);

        $this->app->bind(\App\Repositories\Interfaces\PlatformRepository::class, \App\Repositories\Eloquents\PlatformRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\PlatformMoneyRepository::class, \App\Repositories\Eloquents\PlatformMoneyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\RelationPlatformRepository::class, \App\Repositories\Eloquents\RelationPlatformRepositoryEloquent::class);

        $this->app->bind(\App\Repositories\Interfaces\SupplySingleRepository::class, \App\Repositories\Eloquents\SupplySingleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\SupplyCamRepository::class, \App\Repositories\Eloquents\SupplyCamRepositoryEloquent::class);

        $this->app->bind(\App\Repositories\Interfaces\PurchasingCamiloDetailRepository::class, \App\Repositories\Eloquents\PurchasingCamiloDetailRepositoryEloquent::class);

        $this->app->bind(\App\Repositories\Interfaces\OilSupplyRepository::class, \App\Repositories\Eloquents\OilSupplyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\ForwardRepository::class, \App\Repositories\Eloquents\ForwardRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\PresentForwardRepository::class, \App\Repositories\Eloquents\PresentForwardRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\PresentSettingRepository::class, \App\Repositories\Eloquents\PresentSettingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\PurchasingPerrmissonRepository::class,\App\Repositories\Eloquents\PurchasingPerrmissonRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\AuditRepository::class, \App\Repositories\Eloquents\AuditRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\CamAttachmentRepository::class, \App\Repositories\Eloquents\CamAttachmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\DirectAttachmentRepository::class, \App\Repositories\Eloquents\DirectAttachmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\UserAttachmentRepository::class, \App\Repositories\Eloquents\UserAttachmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\InitializeRepository::class,\App\Repositories\Eloquents\InitializeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\JurisdictionRepository::class, \App\Repositories\Eloquents\JurisdictionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\ConfigureRepository::class,\App\Repositories\Eloquents\ConfigureRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\ReconciliationRepository::class,\App\Repositories\Eloquents\ReconciliationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\DiscountRepository::class,\App\Repositories\Eloquents\DiscountRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Interfaces\InventoryRepository::class,\App\Repositories\Eloquents\InventoryRepositoryEloquent::class);


        $this->app->bind(\App\Repositories\Interfaces\NoticeRepository::class, \App\Repositories\Eloquents\NoticeRepositoryEloquent::class);
        //:end-bindings:
    }
}
