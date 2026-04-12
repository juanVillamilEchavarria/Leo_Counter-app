<?php

namespace App\Infrastructure\Reporte\Resolvers\Queries\Handlers;

use App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryHandlerContract;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\Exceptions\CannotResolveQueryHandlerException;

/**
 * Resolver de los handlers de consulta de reportes acerca de movimientos.
 * al proveer las implementaciones del contrato compartido, asegurate que sean las de movimientos en concreto
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class MovimientoQueryHandlerResolver
{
    public function __construct(
        /** @var iterable<ReporteQueryHandlerContract> */
        private iterable $handlers
    ) {}

    public function resolve(ReportStatisticTypeContract $type): ReporteQueryHandlerContract
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($type)) {
                return $handler;
            }
        }
        throw new CannotResolveQueryHandlerException(
            "No handler found for movimiento type: {$type->value}"
        );
    }
}