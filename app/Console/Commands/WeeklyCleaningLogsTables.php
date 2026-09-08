<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Console\Commands;

use App\Application\Auditoria\Commands\CleanAuditoriasCommand;
use App\Application\Exportacion\Commands\CleanExportacionesCommand;
use App\Shared\Application\Contracts\Bus\CommandBus;
use Illuminate\Console\Command;

/**
 * Comando de consola que limpia los registros de las tablas de logs
 * (auditorías y exportaciones) con 6 meses o más de antigüedad.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
class WeeklyCleaningLogsTables extends Command
{
    protected $signature = 'leo:clear-logs-tables';

    protected $description = 'Limpia los registros de logs (auditorías y exportaciones) con 6 meses o más de antigüedad';

    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $this->commandBus->dispatch(new CleanAuditoriasCommand);
        $this->commandBus->dispatch(new CleanExportacionesCommand);

        $this->info('Tablas de logs limpiadas correctamente');
    }
}
