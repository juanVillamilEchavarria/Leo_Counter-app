<?php

namespace App\Infrastructure\Reporte\Resolvers\Queries\Handlers;

use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use Illuminate\Database\Query\Builder;

/**
 * Resolver de las relaciones de consultas de reportes acerca de presupuesto
 * al proveer las implementaciones del contrato compartido, asegurate que sean las de presupuesto en concreto
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class PresupuestoQueryRelationResolver
{
    public function __construct(
        /** @var iterable<App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryRelationStrategyContract> */
        private iterable $strategies
    ) {}

    public function resolve(
        Builder $query,
        ReporteQueryDTO $dto,
        QueryRelationParamContract $param
    ): Builder {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($dto, $param)) {
                $query = $strategy->apply($query, $dto);
            }
        }
        return $query;
    }
}
