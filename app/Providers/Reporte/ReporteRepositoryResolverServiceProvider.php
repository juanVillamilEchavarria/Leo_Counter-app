<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Domains\Reporte\Resolvers\ReporteQueryPortResolver;

final class ReporteQueryPortResolverServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ReporteQueryPortResolver::class,
            fn($app) => new ReporteQueryPortResolver(
                $app->tagged('reporte.repositories')
            )
        );
    }
}
