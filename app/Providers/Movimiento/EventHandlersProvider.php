<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Movimiento;

use App\Application\Movimiento\EventHandlers\DestroyAttachmentsWhenMovimientoIsWrittenEventHandler;
use App\Application\Movimiento\EventHandlers\MovimientoCreatedFinancialImpactEventHandler;
use App\Application\Movimiento\EventHandlers\MovimientoDeletedFinancialImpactEventHandler;
use App\Application\Movimiento\EventHandlers\UploadAttachmentsWhenMovimientoIsWrittenEventHandler;
use App\Application\Movimiento\Events\AttachmentsForMovimientoCreated;
use App\Application\Movimiento\Events\AttachmentsForMovimientoDeleted;
use App\Domains\Movimiento\Events\AutomatedMovimientoRegistered;
use App\Domains\Movimiento\Events\MovimientoCreated;
use App\Domains\Movimiento\Events\MovimientoDeleted;
use App\Infrastructure\Reporte\EventHandlers\Laravel\LaravelInvalidateReportCacheWhenMovimientoIsWritten;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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


        Event::listen(MovimientoDeleted::class, MovimientoDeletedFinancialImpactEventHandler::class);
        Event::listen(MovimientoDeleted::class, LaravelInvalidateReportCacheWhenMovimientoIsWritten::class);
        Event::listen(AttachmentsForMovimientoDeleted::class, DestroyAttachmentsWhenMovimientoIsWrittenEventHandler::class);
    }
}
