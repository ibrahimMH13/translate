<?php

namespace Ibrhaim13\Translate\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;


class RouteTranslateServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->registerRoutes();
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
                $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
            });
    }

}