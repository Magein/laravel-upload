<?php

namespace Magein\Upload;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Magein\Upload\Lib\UploadFactory;

class UploadServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config.php', 'upload');

        $this->app->singleton('upload', function () {
            return new UploadFactory();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

    public function provides()
    {
        return ['upload'];
    }
}
