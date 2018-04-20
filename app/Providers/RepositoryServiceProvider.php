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

        //:end-bindings:
    }
}
