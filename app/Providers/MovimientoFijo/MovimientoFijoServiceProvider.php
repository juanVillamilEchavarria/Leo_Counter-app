<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\MovimientoFijo;

use App\Application\MovimientoFijo\Queries\Handlers\ListMovimientoFijoFormOptionsHandler;
use App\Domains\Movimiento\Services\MovimientoQueryService;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Infrastructure\FrecuenciaMovimiento\Queries\Executors\EloquentListFrecuenciaMovimientoForForm;
use App\Infrastructure\MovimientoFijo\Persistence\Repositories\Eloquent\EloquentMovimientoFijoRepository;
use App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent\EloquentListActiveCuentaForMovimientoFijoForm;
use App\Infrastructure\TipoMovimiento\Queries\Executors\Eloquent\EloquentListTipoMovimientoForFormQueryExecutor;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListFrecuenciaMovimientoForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListTipoMovimientoForFormContract;
use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoFijo\Resolvers\RecalculateNextDateResolver;
use App\Domains\MovimientoFijo\Strategies\DailyRecalculateForNextDateStrategy;
use App\Domains\MovimientoFijo\Strategies\WeeklyRecalculateForNextDateStrategy;
use App\Domains\MovimientoFijo\Strategies\BiWeeklyRecalculateForNextDateStrategy;
use App\Domains\MovimientoFijo\Strategies\MonthlyRecalculateForNextDateStrategy;
use App\Domains\MovimientoFijo\Strategies\BiMonthlyRecalculateForNextDateStrategy;
use App\Domains\MovimientoFijo\Strategies\QuarterlyRecalculateForNextDateStrategy;
use App\Domains\MovimientoFijo\Strategies\SemiannualRecalculateForNextDateStrategy;
use App\Domains\MovimientoFijo\Strategies\AnnualRecalculateForNextDateStrategy;

/**
 * Service provider del modulo MovimientoFijo.
 * Registra bindings de repositorio y opciones de formulario requeridos por la capa de aplicacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\MovimientoFijo
 * @since 1.0.0
 * @version 1.0.0
 */
final class MovimientoFijoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MovimientoFijoRepositoryContract::class, EloquentMovimientoFijoRepository::class);
        $this->app->singleton(ListFrecuenciaMovimientoForFormContract::class, EloquentListFrecuenciaMovimientoForForm::class);
        $this->app->singleton(ListTipoMovimientoForFormContract::class, EloquentListTipoMovimientoForFormQueryExecutor::class);

        // RecalculateNextDateResolver: registra las estrategias disponibles para la recalculacion de la fecha proxima
        $this->app->bind(RecalculateNextDateResolver::class, function(){
            return new RecalculateNextDateResolver([
                app(DailyRecalculateForNextDateStrategy::class),
                app(WeeklyRecalculateForNextDateStrategy::class),
                app(BiWeeklyRecalculateForNextDateStrategy::class),
                app(MonthlyRecalculateForNextDateStrategy::class),
                app(BiMonthlyRecalculateForNextDateStrategy::class),
                app(QuarterlyRecalculateForNextDateStrategy::class),
                app(SemiannualRecalculateForNextDateStrategy::class),
                app(AnnualRecalculateForNextDateStrategy::class),
            ]);
        });
    }

    public function boot(): void
    {
        //
    }
}
