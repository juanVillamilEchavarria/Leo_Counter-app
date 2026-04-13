<?php

namespace App\Application\Reporte\Providers;

use Illuminate\Support\ServiceProvider;
use App\Application\Reporte\Resolvers\AssemblerResolver;
use App\Application\Reporte\Assemblers\Movimientos\KPIAssembler;
use App\Application\Reporte\Assemblers\Movimientos\IngresosVsGastosAssembler;
use App\Application\Reporte\Assemblers\Movimientos\CategoryDistributionAssembler;
use App\Application\Reporte\Assemblers\Movimientos\BalanceNetoAssembler;
use App\Application\Reporte\Assemblers\Presupuestos\UsedBudgetAssembler;

class AssemblerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AssemblerResolver::class, function ($app) {
            return new AssemblerResolver([
                // Movimientos
                $app->make(KPIAssembler::class),
                $app->make(IngresosVsGastosAssembler::class),
                $app->make(CategoryDistributionAssembler::class),
                $app->make(BalanceNetoAssembler::class),
                
                // Presupuestos
                $app->make(UsedBudgetAssembler::class),
            ]);
        });
    }
}