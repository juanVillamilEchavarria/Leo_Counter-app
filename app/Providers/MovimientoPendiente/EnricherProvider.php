<?php

namespace App\Providers\MovimientoPendiente;

use Illuminate\Support\ServiceProvider;
use App\Application\MovimientoPendiente\Contracts\Enrichers\MovimientoPendienteCollectionEnricherContract;
use App\Infrastructure\MovimientoPendiente\Enricher\Laravel\LaravelMovimientoPendienteCollectionEnricher;

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
