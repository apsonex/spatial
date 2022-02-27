<?php

namespace Apsonex\Countries\Tests;

use Apsonex\Countries\CountriesServiceProvider;
use Dotenv\Dotenv;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestCase extends OrchestraTestCase
{


    protected function setUp(): void
    {
        $this->loadEnvironmentVariables();

        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Apsonex\\Listing\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            CountriesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        // make sure, our .env file is loaded
        $app->useEnvironmentPath(__DIR__ . '/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        parent::getEnvironmentSetUp($app);

        /*
        $migration = include __DIR__.'/../database/migrations/create_skeleton_table.php.stub';
        $migration->up();
        */
    }

    protected function writeArrayToFile($file, array $data): bool|int
    {
        return File::put(
            $file,
            Str::of("<?php /** @noinspection ALL */ \n" . 'return ' . var_export($data, true) . ';')
                ->replace('array (', '[')
                ->replace('),', '],')
                ->replace(');', '];')
                ->__toString()
        );
    }

    protected function loadEnvironmentVariables()
    {
        if (!file_exists(__DIR__ . '/../.env')) {
            return;
        }

        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');

        $dotenv->load();
    }
}