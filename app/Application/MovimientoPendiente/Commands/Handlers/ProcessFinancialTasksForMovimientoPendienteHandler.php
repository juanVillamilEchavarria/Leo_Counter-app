<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Commands\Handlers;

use App\Application\MovimientoPendiente\Commands\MarkMovimientoPendienteAsExpiredCommand;
use App\Application\MovimientoPendiente\Commands\ProcessFinancialTasksForMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Events\MovimientoPendienteExpired;
use App\Application\MovimientoPendiente\Events\MovimientoPendienteWarningDayArrived;
use App\Application\MovimientoPendiente\Queries\ListAllMovimientoPendienteDueForProcessingQuery;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Shared\Domain\Contracts\CollectionContract;

final readonly class ProcessFinancialTasksForMovimientoPendienteHandler
{
    public function __construct(
        private  QueryBus $queryBus,
        private  EventBus $eventBus,
        private  CommandBus $commandBus
    )
    {
    }

    public function __invoke(ProcessFinancialTasksForMovimientoPendienteCommand $command): void
    {
        /** @var CollectionContract<MovimientoPendiente> $movimientosPendientes */
        $movimientosPendientes = $this->queryBus->ask(new ListAllMovimientoPendienteDueForProcessingQuery());
        $warningDays= $movimientosPendientes->filter(fn(MovimientoPendiente $m) => $m->isWarningDay());
        $expiredYesterday = $movimientosPendientes->filter(fn(MovimientoPendiente $m) => $m->wasExpiredYesterday());

        if($warningDays->count()>0){
            $this->eventBus->publish(new MovimientoPendienteWarningDayArrived($warningDays));
        }
        if($expiredYesterday->count()>0){
            $expiredYesterday->map(function (MovimientoPendiente $movimiento){
                $this->commandBus->dispatch(new MarkMovimientoPendienteAsExpiredCommand($movimiento));
            });
            $this->eventBus->publish(new MovimientoPendienteExpired($expiredYesterday));
        }

    }

}
