<?php

namespace App\Providers\MovimientoPendiente;

use App\Application\MovimientoPendiente\Contracts\Enrichers\MovimientoPendienteCollectionEnricherContract;
use App\Infrastructure\MovimientoPendiente\Framework\Laravel\Enricher\LaravelMovimientoPendienteCollectionEnricher;
use Illuminate\Support\ServiceProvider;

class EnricherProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MovimientoPendienteCollectionEnricherContract::class, LaravelMovimientoPendienteCollectionEnricher::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
