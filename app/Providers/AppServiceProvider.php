<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use GuzzleHttp\Client;
use App\Contracts\PokemonServiceInterface;
use App\Services\PokemonService;
use App\Cache\PokemonCache;
use App\Client\PokemonClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PokemonServiceInterface::class, function (Application $app) {
            return new PokemonService(new PokemonClient(new Client()), new PokemonCache());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
