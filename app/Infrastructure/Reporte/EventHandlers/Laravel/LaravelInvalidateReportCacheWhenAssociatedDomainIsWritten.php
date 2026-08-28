<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\EventHandlers\Laravel;

use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;
use App\Shared\Application\Events\InvalidateReportCacheActionOcurred;
use App\Shared\Domain\Contracts\EventContract;
use Illuminate\Support\Facades\Cache;

/**
 * Event handler que invalida la caché de reportes cuando se escribe
 * (crea/actualiza/elimina) un dominio asociado a reportes. Usa la etiqueta 'reportes'.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Contracts\Events
 * @version 1.0.0
 * @since 1.0.0
 */
final class LaravelInvalidateReportCacheWhenAssociatedDomainIsWritten
{

    public function __invoke(InvalidateReportCacheActionOcurred $event): void
    {
        Cache::tags([$event->getKey()])->flush();
    }
}
