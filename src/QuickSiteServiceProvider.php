<?php

namespace Ayimdomnic\QuickSite;


use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use quicksite

/**
* package name: QuickSite
* author: ayimdonic
* email: ayimdomnic@gmail.com
*
*
*/
class QuickSiteServiceProvider extends ServiceProvider
{
	
	public function boot()
	{
		$this->publishes([


			//define the publishables here

		]);

		$this->loadMigrationsFrom(__DIR__.'/Migrations');

        $theme = Config::get('qucksite.frontend-theme', 'default');

        $this->loadViewsFrom(__DIR__.'/Views', 'quicksite');
        View::addLocation(base_path('resources/themes/'.$theme));

        View::addNamespace('quicksite-frontend', base_path('resources/themes/'.$theme));

        /*
        |--------------------------------------------------------------------------
        | Blade Directives
        |--------------------------------------------------------------------------
        */

        Blade::directive('theme', function ($expression) {
            if (Str::startsWith($expression, '(')) {
                $expression = substr($expression, 1, -1);
            }

            $theme = Config::get('quicksite.frontend-theme');
            $view = '"quicksite-frontend::'.str_replace('"', '', str_replace("'", '', $expression)).'"';
            return "<?php echo \$__env->make($view, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        });

        Blade::directive('menu', function ($expression) {
            return "<?php echo quicksite::menu($expression); ?>";
        });

        Blade::directive('widget', function ($expression) {
            return "<?php echo quicksite::widget($expression); ?>";
        });

        Blade::directive('images', function ($expression) {
            return "<?php echo quicksite::images($expression); ?>";
        });

        Blade::directive('edit', function ($expression) {
            return "<?php echo quicksite::editBtn($expression); ?>";
        });
        Blade::directive('markdown', function ($expression) {
            return "<?php echo Markdown::convertToHtml($expression); ?>";
        });
    }

    /**
     * Register the services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Ayimdomnic\Quicksite\Providers\quicksiteServiceProvider::class);
        $this->app->register(\Ayimdomnic\Quicksite\Providers\quicksiteEventServiceProvider::class);
        $this->app->register(\Ayimdomnic\Quicksite\Providers\quicksiteRouteProvider::class);
        $this->app->register(\Ayimdomnic\Quicksite\Providers\quicksiteModuleProvider::class);
        $this->app->register(\Yab\Laracogs\LaracogsProvider::class);
        $this->app->register(\Devfactory\Minify\MinifyServiceProvider::class);
        $this->app->register(\GrahamCampbell\Markdown\MarkdownServiceProvider::class);
        $this->app->register(\Spatie\LaravelAnalytics\LaravelAnalyticsServiceProvider::class);

        $loader = AliasLoader::getInstance();

        $loader->alias('Minify', \Devfactory\Minify\Facades\MinifyFacade::class);
        $loader->alias('Markdown', \GrahamCampbell\Markdown\Facades\Markdown::class);
        $loader->alias('LaravelAnalytics', \Spatie\LaravelAnalytics\LaravelAnalyticsFacade::class);
        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */
        $this->commands([
            \Ayimdomnic\Quicksite\Console\ThemeGenerate::class,
            \Ayimdomnic\Quicksite\Console\ThemePublish::class,
            \Ayimdomnic\Quicksite\Console\ModulePublish::class,
            \Ayimdomnic\Quicksite\Console\ModuleMake::class,
            \Ayimdomnic\Quicksite\Console\ModuleCrud::class,
            \Ayimdomnic\Quicksite\Console\Setup::class,
        ]);

	}
}