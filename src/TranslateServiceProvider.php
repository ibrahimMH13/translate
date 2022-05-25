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
    const MAP =[
      'config'=>'translate13.php',
      'views'=> 'views/vendor/translate13/'
    ];

    const PATH =[
        'resources/views/vendor/translate13',
        '/../../config/config.php'
    ];

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
/*        foreach (self::MAP as $type =>$conf){
            $configType = $this->getTypePath($type, $conf);
            var_dump([
                $this->getPath($type) => $configType,
            ]);
        }*/
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('translate13.php'),
        ], 'translate');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('vendor/translate'),
        ], 'translate');


    }

    /**
     * @return void
     */
    public function loadResources(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'translate');
    }

    protected function routeConfiguration()
    {
        $prefix = config('translate13.locale_prefix')?app()->getLocale() .'/'.config('translate13.prefix'):config('translate13.prefix');
         return [
            'prefix' => $prefix,
            'middleware' =>config('translate13.middleware'),
        ];
    }

    protected function bindPath(){
        return array_combine(array_keys(self::MAP),self::PATH);
    }

    protected function getPath($type): string
    {
        return __DIR__ .$this->bindPath()[$type]??'';
    }

    /**
     * @param string $type
     * @param string $conf
     * @return string
     */
    public function getTypePath(string $type, string $path): string
    {
        switch ($type) {
            case 'config':
                return config_path($path);
            case 'views':
                return resource_path($path);
            default:
                return '';
        }
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
