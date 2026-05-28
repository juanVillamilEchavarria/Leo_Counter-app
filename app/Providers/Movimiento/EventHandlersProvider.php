<?php

namespace App\Providers\Movimiento;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Domains\Movimiento\Events\AttachmentsForMovimientoCreated;
use App\Domains\Movimiento\Events\AttachmentsForMovimientoUpdated;
use App\Domains\Movimiento\Events\AttachmentsForMovimientoDeleted;
use App\Domains\Movimiento\Events\MovimientoCreated;
use App\Domains\Movimiento\Events\MovimientoUpdated;
use App\Domains\Movimiento\Events\MovimientoDeleted;
use App\Domains\Movimiento\Events\AutomatedMovimientoRegistered;
use App\Application\Movimiento\EventHandlers\MovimientoCreatedFinancialImpactEventHandler;
use App\Application\Movimiento\EventHandlers\MovimientoUpdatedFinancialImpactEventHandler;
use App\Application\Movimiento\EventHandlers\MovimientoDeletedFinancialImpactEventHandler;
use App\Application\Movimiento\EventHandlers\UploadAttachmentsWhenMovimientoIsWrittenEventHandler;
use App\Application\Movimiento\EventHandlers\UpdateAttachmentsWhenMovimientoIsWrittenEventHandler;
use App\Application\Movimiento\EventHandlers\DestroyAttachmentsWhenMovimientoIsWrittenEventHandler;
use App\Infrastructure\Reporte\EventHandlers\Laravel\LaravelInvalidateReportCacheWhenMovimientoIsWritten;

/**
 * Provider de handlers de eventos del modulo Movimiento.
 * Registra listeners para los eventos de dominio relacionados con movimientos, incluyendo movimientos automatizados.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\Movimiento
 */
class EventHandlersProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // No bindings required: handlers are concrete and resolved directly by the event dispatcher.
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(MovimientoCreated::class, MovimientoCreatedFinancialImpactEventHandler::class);
        Event::listen(MovimientoCreated::class, LaravelInvalidateReportCacheWhenMovimientoIsWritten::class);
        Event::listen(AttachmentsForMovimientoCreated::class, UploadAttachmentsWhenMovimientoIsWrittenEventHandler::class);
        Event::listen(AutomatedMovimientoRegistered::class, MovimientoCreatedFinancialImpactEventHandler::class);

        Event::listen(MovimientoUpdated::class, MovimientoUpdatedFinancialImpactEventHandler::class);
        Event::listen(MovimientoUpdated::class, LaravelInvalidateReportCacheWhenMovimientoIsWritten::class);
        Event::listen(AttachmentsForMovimientoUpdated::class, UploadAttachmentsWhenMovimientoIsWrittenEventHandler::class);
        Event::listen(AttachmentsForMovimientoUpdated::class, UpdateAttachmentsWhenMovimientoIsWrittenEventHandler::class);
        Event::listen(AttachmentsForMovimientoUpdated::class, DestroyAttachmentsWhenMovimientoIsWrittenEventHandler::class);

        Event::listen(MovimientoDeleted::class, MovimientoDeletedFinancialImpactEventHandler::class);
        Event::listen(MovimientoDeleted::class, LaravelInvalidateReportCacheWhenMovimientoIsWritten::class);
        Event::listen(AttachmentsForMovimientoDeleted::class, DestroyAttachmentsWhenMovimientoIsWrittenEventHandler::class);
    }
}
