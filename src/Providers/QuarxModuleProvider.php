<?php

namespace Ayimdomnic\QuickSite\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class QuarxModuleProvider extends ServiceProvider
{
    /**
     * Register the services.
     *
     * @return void
     */
    public function register()
    {
        if (Config::get('quicksite.load-modules', false)) {
            $modulePath = base_path(Config::get('quicksite.module-directory').'/');
            $modules = glob($modulePath.'*');

            foreach ($modules as $module) {
                if (is_dir($module)) {
                    $module = lcfirst(str_replace($modulePath, '', $module));
                    $this->app->register('\quicksite\Modules\\'.ucfirst($module).'\\'.ucfirst($module).'ModuleProvider');
                }
            }
        }
    }
}
