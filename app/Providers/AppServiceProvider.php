<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Import Interfaces dan Implementations
use App\Repositories\Interfaces\PaketRepositoryInterface;
use App\Repositories\Eloquent\PaketRepository;
use App\Repositories\Interfaces\PemesananRepositoryInterface;
use App\Repositories\Eloquent\PemesananRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // BINDING REPOSITORY (Wajib ada biar gak 500)
        $this->app->bind(PaketRepositoryInterface::class, PaketRepository::class);
        $this->app->bind(PemesananRepositoryInterface::class, PemesananRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}