<?php

namespace App\Console\Commands;

use App\Application\MovimientoFijo\Commands\ProcessFinancialTaskForMovimientoFijoCommand;
use App\Application\MovimientoPendiente\Commands\ProcessFinancialTasksForMovimientoPendienteCommand;
use Illuminate\Console\Command;
use App\Shared\Application\Contracts\Bus\CommandBus;

class ProcessDailyFinancialTasks extends Command
{
    public function __construct(
        private readonly CommandBus $commandBus,

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
        $this->commandBus->dispatch(new ProcessFinancialTaskForMovimientoFijoCommand());
        $this->commandBus->dispatch(new ProcessFinancialTasksForMovimientoPendienteCommand());
        $this->info('Tareas financieras diarias procesadas');
    }


}
