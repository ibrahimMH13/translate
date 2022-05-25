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
        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            $local = $app['config']['app.local'];
            $translate = new Translator($loader, $local);
            $translate->setFallback($app['config']['app.fallback_locale']);
            return $translate;
        });
    }

}
