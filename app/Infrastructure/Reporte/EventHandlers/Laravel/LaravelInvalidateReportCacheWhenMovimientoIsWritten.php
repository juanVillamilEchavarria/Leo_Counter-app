<?php

namespace App\Infrastructure\Reporte\EventHandlers\Laravel;

use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;
use Illuminate\Support\Facades\Cache;

/**
 * Event handler que invalida la caché de reportes cuando se escribe
 * (crea/actualiza/elimina) un Movimiento. Usa la etiqueta 'reportes'.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Contracts\Events
 * @version 1.0.0
 * @since 1.0.0
 */
final class LaravelInvalidateReportCacheWhenMovimientoIsWritten
{
    /** Ejecutar el job después de que la transacción se haya confirmado */
    public bool $afterCommit = true;

    public function __invoke(MovimientoEventContract $event): void
    {
        Cache::tags(['reportes'])->flush();
    }
}
