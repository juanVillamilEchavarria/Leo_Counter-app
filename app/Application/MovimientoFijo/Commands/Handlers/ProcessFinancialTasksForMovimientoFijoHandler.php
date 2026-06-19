<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoFijo\Commands\Handlers;

use App\Application\Movimiento\Commands\RegisterMovimientoFromMovimientoFijoCommand;
use App\Application\MovimientoFijo\Commands\ProcessFinancialTaskForMovimientoFijoCommand;
use App\Application\MovimientoFijo\Events\AutomatedMovimientoFijoProcessed;
use App\Application\MovimientoFijo\Events\MovimientoFijoWarningDayArrived;
use App\Application\MovimientoFijo\Queries\ListAllMovimientoFijoDueForProcessingQuery;
use App\Application\MovimientoPendiente\Commands\RegisterMovimientoPendienteFromMovimientoFijoCommand;
use App\Application\MovimientoPendiente\Events\MovimientoPendienteCreatedFromMovimientoFijo;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Domains\MovimientoFijo\Resolvers\RecalculateNextDateResolver;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Domain\ValueObjects\Date;

final readonly class ProcessFinancialTasksForMovimientoFijoHandler
{
    public function __construct(
        private  QueryBus $queryBus,
        private  EventBus $eventBus,
        private  CommandBus $commandBus,
        private  MovimientoFijoRepositoryContract $movimientoFijoRepositoryContract,
        private  RecalculateNextDateResolver $recalculateNextDateResolver
    )
    {
    }

    public function __invoke(ProcessFinancialTaskForMovimientoFijoCommand $command):void
    {
        /** @var CollectionContract<MovimientoFijo> $movimientoFijos */
        $movimientoFijos = $this->queryBus->ask(
            new ListAllMovimientoFijoDueForProcessingQuery()
        );
        $warningDays = $movimientoFijos->filter(fn(MovimientoFijo $m) => $m->isWarningDay());
        $dueToday = $movimientoFijos->filter(fn(MovimientoFijo $m) => $m->isDueToday());
        $registered = $dueToday->filter(fn(MovimientoFijo $m) => $m->getRegistrarAutomatico());
        $pending = $dueToday->filter(fn(MovimientoFijo $m) => !$m->getRegistrarAutomatico());
        // procesamos los movimientos que se deben hacer hoy
        $dueToday->map(function (MovimientoFijo $movimientoFijo) {
            if ($movimientoFijo->getRegistrarAutomatico()) {
                $this->commandBus->dispatch(new RegisterMovimientoFromMovimientoFijoCommand($movimientoFijo));
            } else {
                $this->commandBus->dispatch(new RegisterMovimientoPendienteFromMovimientoFijoCommand($movimientoFijo));
            }

            $updatedMovimiento = $movimientoFijo->recalculateNextDate($this->recalculateNextDateResolver);
            $this->movimientoFijoRepositoryContract->update($updatedMovimiento);
        });
        // lanzamos los eventos de aplicacion (caso de uso)
        if($warningDays->count()>0){
            $this->eventBus->publish(new MovimientoFijoWarningDayArrived($warningDays));
        }
        if($registered->count()>0){
            $this->eventBus->publish(new AutomatedMovimientoFijoProcessed(
                movimientosFijos: $registered
            ));
        }
        if($pending->count()>0){
            $this->eventBus->publish(new MovimientoPendienteCreatedFromMovimientoFijo(
                movimientosFijos: $pending
            ));
        }

    }

}
