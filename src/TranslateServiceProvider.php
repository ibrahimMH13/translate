<?php

namespace Ibrhaim13\Translate;

use Illuminate\Support\Facades\Route;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;
use function app;
use function config;
use function config_path;
use function resource_path;

class TranslateServiceProvider extends BaseTranslationServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        $this->registerLoader();
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'translate13');
        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            $local = $app['config']['app.local'];
            $translate = new Translator($loader, $local);
            $translate->setFallback($app['config']['app.fallback_locale']);
            return $translate;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->loadResources();

    }

    /**
     * @return void
     */
    public function publish(): void
    {
         $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('translate13.php'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('vendor/translate13'),
        ], 'views');


    }

    /**
     * @return void
     */
    public function loadResources(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'translate');
    }
    protected function registerRoutes()
    {
        $prefix = config('translate13.locale_prefix')?app()->getLocale() .'/'.config('translate13.prefix'):config('translate13.prefix');
        Route::group([
            'prefix' => $prefix,
            'namespace' => 'Ibrhaim13\Translate\Http\Controllers',
            'as' => 'translate.',
            'middleware' =>config('translate13.middleware'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

}
