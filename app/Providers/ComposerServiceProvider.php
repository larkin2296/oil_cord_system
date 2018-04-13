<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*sidebar 菜单*/
       // View::composer(getThemeTemplate('layout.partical.admin.sidebar'), \App\Http\ViewComposers\SidebarMenuComposer::class);
        /*顶部company*/
       // View::composer(getThemeTemplate('layout.partical.admin.header'), \App\Http\ViewComposers\HeaderCompanyComposer::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
