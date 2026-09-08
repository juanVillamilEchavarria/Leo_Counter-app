<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.1.0
 */

namespace App\Providers\Auditoria;

use App\Application\Auditoria\Commands\CleanAuditoriasCommand;
use App\Application\Auditoria\Commands\DestroyAuditoriaCommand;
use App\Application\Auditoria\Commands\Handlers\CleanAuditoriasHandler;
use App\Application\Auditoria\Commands\Handlers\DestroyAuditoriaHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

/**
 * Provider que registra el mapeo explícito entre comandos de aplicación
 * y sus handlers del módulo Auditoría.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final class AuditoriaBusProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Bus::map([
            CleanAuditoriasCommand::class => CleanAuditoriasHandler::class,
            DestroyAuditoriaCommand::class => DestroyAuditoriaHandler::class,
        ]);
    }
}
