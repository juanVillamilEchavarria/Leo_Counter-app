<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Providers\Exportacion;

use App\Application\Exportacion\Events\TooManyRecordsExported;
use App\Infrastructure\Exportacion\Framework\Laravel\EventHandlers\LaravelSendMessageToAdminWhenTooManyRecordsExportedEventHandler;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/**
 * Provider que registra los event handlers del módulo Exportación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final class ExportEventHandlersProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(
            TooManyRecordsExported::class,
            LaravelSendMessageToAdminWhenTooManyRecordsExportedEventHandler::class
        );
    }
}
