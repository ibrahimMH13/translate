<?php

namespace Ibrhaim13\Translate\Providers;
use Ibrhaim13\Translate\Translator;
use Illuminate\Support\Facades\Route;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;

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
       $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'app');
        $this->app->singleton('translator',function ($app){
           $loader = $app['translation.loader'];
           $local = $app['config']['app.local'];
           $translate = new Translator($loader,$local);
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
        $this->loadResources();
        if ($this->app->runningInConsole())  $this->publish();

    }

    /**
     * @return void
     */
    public function publish(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('translate13.php'),
        ], 'config');
    }

    /**
     * @return void
     */
    public function loadResources(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        $prefix = config('translate13.locale_prefix')?config('translate13.locale_prefix') .'/'.config('translate13.prefix'):config('translate13.prefix');
        return [
            'prefix' => $prefix,
            'middleware' => config('translate13.middleware'),
        ];
    }

}
