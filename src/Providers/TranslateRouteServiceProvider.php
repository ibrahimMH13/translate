<?php

namespace Ibrhaim13\Translate\Providers;

use Ibrhaim13\Translate\Http\Middleware\Web\Localization;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;

class TranslateRouteServiceProvider extends BaseTranslationServiceProvider
{
    public function register()
    {
       $this->registerLoader();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup('web', Localization::class);
        $router->pushMiddlewareToGroup('api', \Ibrhaim13\Translate\Http\Middleware\Api\Localization::class);


    }


    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        $prefix = config('translate13.locale_prefix')?config('translate13.prefix')?app()->getLocale():app()->getLocale() .'/'.config('translate13.prefix'):config('translate13.prefix');
         return [
            'prefix' => $prefix,
            'middleware' =>config('translate13.middleware'),
        ];
    }

}
