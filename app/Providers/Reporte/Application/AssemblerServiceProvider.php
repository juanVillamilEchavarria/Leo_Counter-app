<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Reporte\Application;

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