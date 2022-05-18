<?php

namespace Ibrhaim13\Translate\Providers;
use Ibrhaim13\Translate\Translator;
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
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
