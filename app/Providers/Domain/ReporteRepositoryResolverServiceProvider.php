<?php

namespace App\Providers\Domain;

use Illuminate\Support\ServiceProvider;
use App\Domains\Reporte\Resolvers\ReporteRepositoryResolver;

class ReporteRepositoryResolverServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ReporteRepositoryResolver::class,
            fn($app) => new ReporteRepositoryResolver(
                $app->tagged('reporte.repositories')
            )
        );
    }
}
