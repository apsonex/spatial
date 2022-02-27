<?php

namespace Apsonex\Spatial;

use Illuminate\Support\ServiceProvider;

class SpatialServiceProvider extends ServiceProvider
{

    const CONFIG_PATH = __DIR__ . '/../config/spatial.php';

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                self::CONFIG_PATH => config_path('spatial.php'),
            ], 'countries');
        }
    }


    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'spatial');
    }

    protected function getPackageBaseDir(): string
    {
        $reflector = new \ReflectionClass(get_class($this));

        return dirname($reflector->getFileName());
    }
}