<?php

namespace Ibrhaim13\Translate\Providers;
use App\Http\Middleware\Web\Localization;
use Ibrhaim13\Translate\Translator;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;

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
        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup('web', Localization::class);
        $router->pushMiddlewareToGroup('api', \App\Http\Middleware\Api\Localization::class);

        if ($this->app->runningInConsole())
            $this->publish();

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
            __DIR__.'/../../config/config.php' => config_path('translate13.php'),
        ], 'config');
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor'),
        ], 'views');


    }

    /**
     * @return void
     */
    public function loadResources(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'translate13');
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
}
