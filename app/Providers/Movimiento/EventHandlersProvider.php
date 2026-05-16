<?php

namespace App\Providers\Movimiento;

use App\Application\Movimiento\Contracts\EventHandlers\DestroyAttachmentsWhenMovimientoIsWrittenEventHandlerContract;
use App\Application\Movimiento\Contracts\EventHandlers\UpdateAttachmentsWhenMovimientoIsWrittenEventHandlerContract;
use App\Application\Movimiento\EventHandlers\MovimientoDeletedFinancialImpactEventHandler;
use App\Application\Movimiento\EventHandlers\MovimientoUpdatedFinancialImpactEventHandler;
use App\Domains\Movimiento\Contracts\Events\UpdateAttachmentsForMovimientoEventContract;
use App\Domains\Movimiento\Events\MovimientoCreated;
use App\Domains\Movimiento\Events\MovimientoDeleted;
use App\Domains\Movimiento\Events\MovimientoUpdated;
use App\Infrastructure\Movimiento\EventHandlers\Laravel\LaravelDestroyAttachmentsWhenMovimientoIsWrittenEventHadler;
use App\Infrastructure\Movimiento\EventHandlers\Laravel\LaravelUpdateAttachmentsWhenMovimientoIsWrittenEventHandler;
use Illuminate\Support\ServiceProvider;
use App\Application\Movimiento\EventHandlers\MovimientoCreatedFinancialImpactEventHandler;
use App\Application\Movimiento\Contracts\EventHandlers\UploadAttachmentsWhenMovimientoIsWrittenEventHandlerContract;
use App\Infrastructure\Movimiento\EventHandlers\Laravel\LaravelUploadAttachmentsWhenMovimientoIsWrittenEventHandler;
use Illuminate\Support\Facades\Event;
class EventHandlersProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UploadAttachmentsWhenMovimientoIsWrittenEventHandlerContract::class, LaravelUploadAttachmentsWhenMovimientoIsWrittenEventHandler::class);
        $this->app->bind(UpdateAttachmentsWhenMovimientoIsWrittenEventHandlerContract::class, LaravelUpdateAttachmentsWhenMovimientoIsWrittenEventHandler::class);
        $this->app->bind(DestroyAttachmentsWhenMovimientoIsWrittenEventHandlerContract::class, LaravelDestroyAttachmentsWhenMovimientoIsWrittenEventHadler::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       Event::listen(MovimientoCreated::class, MovimientoCreatedFinancialImpactEventHandler::class);
        Event::listen(MovimientoCreated::class, UploadAttachmentsWhenMovimientoIsWrittenEventHandlerContract::class);

        Event::listen(MovimientoUpdated::class, MovimientoUpdatedFinancialImpactEventHandler::class);
        Event::listen(MovimientoUpdated::class, UploadAttachmentsWhenMovimientoIsWrittenEventHandlerContract::class);
        Event::listen(MovimientoUpdated::class, UpdateAttachmentsWhenMovimientoIsWrittenEventHandlerContract::class);
        Event::listen(MovimientoUpdated::class, DestroyAttachmentsWhenMovimientoIsWrittenEventHandlerContract::class);

        Event::listen(MovimientoDeleted::class, MovimientoDeletedFinancialImpactEventHandler::class);
        Event::listen(MovimientoDeleted::class, DestroyAttachmentsWhenMovimientoIsWrittenEventHandlerContract::class);
    }
}
