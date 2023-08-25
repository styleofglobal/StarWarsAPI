<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MovieAPIService;

class MovieServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MovieAPIService::class, function ($app) {
            return new MovieAPIService();
        });
    }
}