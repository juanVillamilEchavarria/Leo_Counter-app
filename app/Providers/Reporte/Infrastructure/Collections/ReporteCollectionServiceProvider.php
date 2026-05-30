<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Reporte\Infrastructure\Collections;

use App\Domains\Reporte\Contracts\Collections\Movimientos\BalanceNetoCollectionContract;
use App\Domains\Reporte\Contracts\Collections\Movimientos\CategoryDistributionCollectionContract;
use App\Domains\Reporte\Contracts\Collections\Movimientos\IncomeExpenseCollectionContract;
use App\Domains\Reporte\Contracts\Collections\Movimientos\KPICollectionContract;
use App\Domains\Reporte\Contracts\Collections\Movimientos\MetricPointCollectionContract;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelBalanceNetoCollection;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelCategoryDistributionCollection;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelIncomeExpenseCollection;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelKPICollection;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelMetricPointCollection;
use Illuminate\Support\ServiceProvider;

/**
 * Service Provider que registra las implementaciones de colecciones
 * específicas del módulo de Reportes.
 *
 * Todas las collections están taggeadas como 'reporte.collections'
 * para facilitar su resolución en batch.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
class ReporteCollectionServiceProvider extends ServiceProvider
{
    /**
     * Array de bindings: Contrato => Implementación
     */
    public array $bindings = [
        KPICollectionContract::class => LaravelKPICollection::class,
        BalanceNetoCollectionContract::class => LaravelBalanceNetoCollection::class,
        CategoryDistributionCollectionContract::class => LaravelCategoryDistributionCollection::class,
        IncomeExpenseCollectionContract::class => LaravelIncomeExpenseCollection::class,
        MetricPointCollectionContract::class => LaravelMetricPointCollection::class,
    ];

    public function register(): void
    {
        foreach ($this->bindings as $contract => $implementation) {
            $this->app->bind($contract, $implementation);
        }

        // Taggear todas las implementaciones
        $this->app->tag(
            array_values($this->bindings),
            'reporte.collections'
        );
    }

    public function provides(): array
    {
        return array_keys($this->bindings);
    }
}