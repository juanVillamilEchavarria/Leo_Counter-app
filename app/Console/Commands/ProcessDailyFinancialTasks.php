<?php

namespace App\Console\Commands;

use App\Application\MovimientoFijo\Contracts\Queries\Executors\MovimientoFijoQueryExecutorContract;
use App\Application\MovimientoFijo\Queries\ListAllMovimientoFijoDueForProcessingQuery;
use App\Application\MovimientoPendiente\Queries\ListAllMovimientoPendienteDueForProcessingQuery;
use App\Application\MovimientoPendiente\Commands\RegisterMovimientoPendienteFromMovimientoFijoCommand;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Console\Command;
use App\Domains\MovimientoFijo\Events\MovimientoFijoWarningDayArrived;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Domain\ValueObjects\Date;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Application\Movimiento\Commands\RegisterMovimientoFromMovimientoFijoCommand;
use App\Domains\MovimientoFijo\Resolvers\RecalculateNextDateResolver;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;

class ProcessDailyFinancialTasks extends Command
{
    public function __construct(
        private readonly MovimientoFijoRepositoryContract $movimientoFijoRepositoryContract,
        private readonly QueryBus $queryBus,
        private readonly EventBus $eventBus,
        private readonly CommandBus $commandBus,
        private readonly RecalculateNextDateResolver $recalculateNextDateResolver
    )
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leo:process-daily-financial-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesa las tareas financieras diarias';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }

    private function processMovimientosFijos(){
        /** @var MovimientoFijo[] $movimientoFijos */
        $movimientoFijos = $this->queryBus->ask(
            new ListAllMovimientoFijoDueForProcessingQuery()
        );
        foreach($movimientoFijos as $movimientoFijo){
            if($movimientoFijo->isWariningDay()){
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

    private function processMovimientosPendientes(){
        $movimientosPendientes = $this->queryBus->ask(new ListAllMovimientoPendienteDueForProcessingQuery());

    }
}
