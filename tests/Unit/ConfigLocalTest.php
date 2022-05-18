<?php


namespace Ibrhaim13\Translate\Tests\Unit;


use Ibrhaim13\Translate\Tests\TestCase;
use Illuminate\Support\Facades\Config;

class ConfigLocalTest extends TestCase
{
    /**
     * @test
     */

    public function locales_config_is_exists(){
        $this->assertIsArray(config('app.locales'));
    }


    /**
     * @test
     */

    public function locals_config_is_not_exists()
    {
        Config::set('app.locales', []);
        $appLocal = Config::get('app.locales');
        $this->assertEmpty($appLocal);
        $this->assertEquals(Config::get('app.fallback_locale'),$this->app->getLocale());
    }
}