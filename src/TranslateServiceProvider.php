<?php

namespace Ibrhaim13\Translate;

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
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'translate13');
        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            $local = $app['config']['app.local'];
            $translate = new Translator($loader, $local);
            $translate->setFallback($app['config']['app.fallback_locale']);
            return $translate;
        });
    }

}
