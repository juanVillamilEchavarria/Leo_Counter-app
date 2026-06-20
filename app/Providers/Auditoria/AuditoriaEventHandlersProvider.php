<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Auditoria;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Shared\Application\Events\AuditableActionOcurred;
use App\Application\Auditoria\EventHandlers\RegisterForAuditEventHandler;

/**
 * Provider que registra los event handlers del módulo Auditoría.
 */
final class AuditoriaEventHandlersProvider extends ServiceProvider
{
    public function register(): void
    {
        // No bindings required
    }

    public function boot(): void
    {
        Event::listen(AuditableActionOcurred::class, RegisterForAuditEventHandler::class);
    }
}
