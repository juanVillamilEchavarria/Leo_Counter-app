<?php

namespace App\Application\MovimientoFijo\Commands\Handlers;

use App\Application\Movimiento\Commands\RegisterMovimientoFromMovimientoFijoCommand;
use App\Application\MovimientoFijo\Commands\ProcessFinancialTaskForMovimientoFijoCommand;
use App\Application\MovimientoFijo\Queries\ListAllMovimientoFijoDueForProcessingQuery;
use App\Application\MovimientoPendiente\Commands\RegisterMovimientoPendienteFromMovimientoFijoCommand;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Domains\MovimientoFijo\Events\MovimientoFijoWarningDayArrived;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\MovimientoFijo\Resolvers\RecalculateNextDateResolver;

final readonly class ProcessFinancialTasksForMovimientoFijoHandler
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly EventBus $eventBus,
        private readonly CommandBus $commandBus,
        private readonly MovimientoFijoRepositoryContract $movimientoFijoRepositoryContract,
        private readonly RecalculateNextDateResolver $recalculateNextDateResolver
    )
    {
    }

    public function __invoke(ProcessFinancialTaskForMovimientoFijoCommand $command):void
    {
        /** @var MovimientoFijo[] $movimientoFijos */
        $movimientoFijos = $this->queryBus->ask(
            new ListAllMovimientoFijoDueForProcessingQuery()
        );
        foreach($movimientoFijos as $movimientoFijo){
            if($movimientoFijo->isWarningDay()){
                $this->eventBus->publish(new MovimientoFijoWarningDayArrived($movimientoFijo, new Date( new \DateTimeImmutable())));
            }

            if($movimientoFijo->isDueToday()){
                if($movimientoFijo->getRegistrarAutomatico()){
                    $this->commandBus->dispatch(new RegisterMovimientoFromMovimientoFijoCommand($movimientoFijo));
                }else{
                    $this->commandBus->dispatch(new RegisterMovimientoPendienteFromMovimientoFijoCommand($movimientoFijo));
                }
                $movimientoFijo = $movimientoFijo->recalculateNextDate($this->recalculateNextDateResolver);
                $this->movimientoFijoRepositoryContract->update($movimientoFijo);
            }
        }
    }

}
