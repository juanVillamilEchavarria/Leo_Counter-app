<?php

namespace App\Providers\Home;
use App\Domains\Home\Services\HomeQueryService;
use App\Application\Reporte\Contracts\Orchestrators\ReporteRepositoryContract;
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
