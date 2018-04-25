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
        $this->app->bind(\App\Repositories\Interfaces\PurchasingCamiloDetailRepository::class, \App\Repositories\Eloquents\PurchasingCamiloDetailRepositoryEloquent::class);
        //:end-bindings:
    }
}
