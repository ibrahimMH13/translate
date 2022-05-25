<?php

namespace Ibrhaim13\Translate;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use function app;
use function config;

class RoutesTranslateServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'translate13');
        $this->registerRoutes();
        $this->loadResources();
        if ($this->app->runningInConsole()) {
            $this->publish();
        }
    }

    protected function registerRoutes()
    {
        $prefix = config('translate13.locale_prefix') ? app()->getLocale() . '/' . config('translate13.prefix') : config('translate13.prefix');
        Route::group([
            'prefix' => $prefix,
            'namespace' => 'Ibrhaim13\Translate\Http\Controllers',
            'as' => 'translate.',
            'middleware' => config('translate13.middleware'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * @return void
     */
    public function publish(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('translate13.php'),
            ], 'config');
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('vendor/translate'),
            ], 'views');
           if (!class_exists('CreatePostsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_translate_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_translate_table.php'),
                ], 'migrations');
            }
        }
    }

    /**
     * @return void
     */
    public function loadResources(): void
    {
      //  $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'translate');
    }

}
