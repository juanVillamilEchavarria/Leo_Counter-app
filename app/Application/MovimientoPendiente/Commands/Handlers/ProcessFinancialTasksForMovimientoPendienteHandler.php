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
use App\Application\MovimientoPendiente\Events\MovimientoPendienteWarningDayArrived;
use App\Application\MovimientoPendiente\Queries\ListAllMovimientoPendienteDueForProcessingQuery;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Application\Contracts\Bus\QueryBus;

final readonly class ProcessFinancialTasksForMovimientoPendienteHandler
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly EventBus $eventBus,
        private readonly CommandBus $commandBus
    )
    {
    }

    public function __invoke(ProcessFinancialTasksForMovimientoPendienteCommand $command): void
    {
        /** @var MovimientoPendiente[] $movimientosPendientes */
        $movimientosPendientes = $this->queryBus->ask(new ListAllMovimientoPendienteDueForProcessingQuery());
        foreach($movimientosPendientes as $movimientoPendiente){
            if($movimientoPendiente->isWarningDay()){
                $this->eventBus->publish(new MovimientoPendienteWarningDayArrived($movimientoPendiente));
            }

            if($movimientoPendiente->wasExpiredYesterday()){
                $this->commandBus->dispatch(new MarkMovimientoPendienteAsExpiredCommand($movimientoPendiente));
            }
        }
    }

}
