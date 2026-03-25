<?php

namespace App\Domains\Home\Providers;
use App\Domains\Home\Services\Domain\HomeQueryService;
use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
use App\Domains\Reporte\Repositories\Application\Cache\CacheReporteRepository;
use Illuminate\Support\ServiceProvider;

class HomeProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(HomeQueryService::class)
        ->needs(ReporteRepositoryContract::class)
        ->give(CacheReporteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
