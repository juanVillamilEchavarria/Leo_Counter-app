<?php

namespace App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Resolvers;

use App\Infrastructure\QueryHandlers\Reporte\Contracts\ReporteQueryHandlerContract;
use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;
use App\Domains\Reporte\Exceptions\CannotResolveQueryHandlerException;

final class PresupuestoQueryHandlerResolver
{
    public function __construct(
        /** @var iterable<ReporteQueryHandlerContract> */
        private iterable $handlers
    ) {}

    public function resolve(ReporteQueryTypeContract $type): ReporteQueryHandlerContract
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($type)) {
                return $handler;
            }
        }
        throw new CannotResolveQueryHandlerException(
            "No handler found for presupuesto type: {$type->value}"
        );
    }
}