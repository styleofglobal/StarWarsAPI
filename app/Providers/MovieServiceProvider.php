<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MovieAPIService;

class MovieServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MovieAPIService::class, function () {
            return new MovieAPIService(config('services.tmdb.api_key'));
        });
    }
}
