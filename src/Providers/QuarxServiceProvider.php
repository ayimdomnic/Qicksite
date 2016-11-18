<?php

namespace Ayimdomnic\QuickSite\Providers;

use App;
use Ayimdomnic\QuickSite\Services\BlogService;
use Ayimdomnic\QuickSite\Services\CryptoService;
use Ayimdomnic\QuickSite\Services\EventService;
use Ayimdomnic\QuickSite\Services\ModuleService;
use Ayimdomnic\QuickSite\Services\PageService;
use Ayimdomnic\QuickSite\Services\quicksiteService;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class QuarxServiceProvider extends ServiceProvider
{
    /**
     * Register the services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('quicksite', \Ayimdomnic\QuickSite\Facades\quicksiteServiceFacade::class);
        $loader->alias('PageService', \Ayimdomnic\QuickSite\Facades\PageServiceFacade::class);
        $loader->alias('EventService', \Ayimdomnic\QuickSite\Facades\EventServiceFacade::class);
        $loader->alias('CryptoService', \Ayimdomnic\QuickSite\Facades\CryptoServiceFacade::class);
        $loader->alias('ModuleService', \Ayimdomnic\QuickSite\Facades\ModuleServiceFacade::class);
        $loader->alias('BlogService', \Ayimdomnic\QuickSite\Facades\BlogServiceFacade::class);
        $loader->alias('FileService', \Ayimdomnic\QuickSite\Services\FileService::class);

        $this->app->bind('quicksiteService', function ($app) {
            return new quicksiteService();
        });

        $this->app->bind('PageService', function ($app) {
            return new PageService();
        });

        $this->app->bind('EventService', function ($app) {
            return App::make(EventService::class);
        });

        $this->app->bind('CryptoService', function ($app) {
            return new CryptoService();
        });

        $this->app->bind('ModuleService', function ($app) {
            return new ModuleService();
        });

        $this->app->bind('BlogService', function ($app) {
            return new BlogService();
        });
    }
}
