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
        //:end-bindings:
    }
}
