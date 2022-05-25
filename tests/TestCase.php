<?php
namespace Ibrhaim13\Translate\Tests;
use Ibrhaim13\Translate\TranslateServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BasicTestCase;

class TestCase extends BasicTestCase
{
    use RefreshDatabase;
    protected $loadEnvironmentVariables = true;

    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            TranslateServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // import the CreatePostsTable class from the migration
        include_once __DIR__ . '/../database/migrations/create_translate_table.php';
        $app['config']->set('database.default', 'test_translate');
        $app['config']->set('database.connections.test_translate', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        // run the up() method of that migration class
        (new \TranslateTable)->up();

    }

}