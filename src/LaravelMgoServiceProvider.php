<?php

namespace ThemisMin\LaravelMgo;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class LaravelMgoServiceProvider extends ServiceProvider
{
    /**
     * Boot the provider.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the provider.
     */
    public function register()
    {
        $configSource = realpath(__DIR__ . '/../config/laravel-mgo.php');
        $this->publishes([$configSource => config_path('laravel-mgo.php')], 'config');
        $this->mergeConfigFrom($configSource, 'laravel-mgo');

        $databasePath = realpath(__DIR__ . '/../database/');
        foreach (Finder::create()->files()->name('*.php')->in($databasePath) as $file) {
            /** @var SplFileInfo $file */
            $this->publishes([$file->getPathname() => database_path($file->getRelativePathname())], 'migrations');
        }
    }
}
