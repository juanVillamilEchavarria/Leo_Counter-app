<?php

namespace App\Providers\Movimiento;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Domains\Movimiento\Events\MovimientoCreated;
use App\Domains\Movimiento\Events\MovimientoUpdated;
use App\Domains\Movimiento\Events\MovimientoDeleted;
use App\Application\Movimiento\EventHandlers\MovimientoCreatedFinancialImpactEventHandler;
use App\Application\Movimiento\EventHandlers\MovimientoUpdatedFinancialImpactEventHandler;
use App\Application\Movimiento\EventHandlers\MovimientoDeletedFinancialImpactEventHandler;
use App\Application\Movimiento\EventHandlers\UploadAttachmentsWhenMovimientoIsWrittenEventHandler;
use App\Application\Movimiento\EventHandlers\UpdateAttachmentsWhenMovimientoIsWrittenEventHandler;
use App\Application\Movimiento\EventHandlers\DestroyAttachmentsWhenMovimientoIsWrittenEventHandler;
use App\Infrastructure\Reporte\EventHandlers\Laravel\LaravelInvalidateReportCacheWhenMovimientoIsWritten;

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
        Event::listen(MovimientoCreated::class, UploadAttachmentsWhenMovimientoIsWrittenEventHandler::class);
       Event::listen(MovimientoCreated::class, LaravelInvalidateReportCacheWhenMovimientoIsWritten::class);

        Event::listen(MovimientoUpdated::class, MovimientoUpdatedFinancialImpactEventHandler::class);
        Event::listen(MovimientoUpdated::class, UploadAttachmentsWhenMovimientoIsWrittenEventHandler::class);
       Event::listen(MovimientoUpdated::class, LaravelInvalidateReportCacheWhenMovimientoIsWritten::class);
        Event::listen(MovimientoUpdated::class, UpdateAttachmentsWhenMovimientoIsWrittenEventHandler::class);
        Event::listen(MovimientoUpdated::class, DestroyAttachmentsWhenMovimientoIsWrittenEventHandler::class);

        Event::listen(MovimientoDeleted::class, MovimientoDeletedFinancialImpactEventHandler::class);
        Event::listen(MovimientoDeleted::class, DestroyAttachmentsWhenMovimientoIsWrittenEventHandler::class);
       Event::listen(MovimientoDeleted::class, LaravelInvalidateReportCacheWhenMovimientoIsWritten::class);
    }
}
