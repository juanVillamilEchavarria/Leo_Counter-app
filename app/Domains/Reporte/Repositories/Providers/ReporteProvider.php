<?php

namespace App\Domains\Reporte\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
use App\Domains\Reporte\Repositories\Application\Eloquent\ReporteRepository;

class ReporteProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ReporteRepositoryContract::class, ReporteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
