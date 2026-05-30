<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
