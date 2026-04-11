<?php

namespace App\Infrastructure\QueryHandlers\Reporte\Movimiento\Resolvers;

use App\Infrastructure\QueryHandlers\Reporte\Contracts\QueryRelationStrategyContract;
use App\Shared\Domain\Contracts\Reporte\QueryRelationParamContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\Domain\QueryBuilders\DomainQueryBuilder;

final class MovimientoQueryRelationResolver
{
    public function __construct(
        /** @var iterable<QueryRelationStrategyContract> */
        private iterable $strategies
    ) {}

    public function resolve(
        DomainQueryBuilder $query,
        ReporteQueryDTO $dto,
        QueryRelationParamContract $param
    ): DomainQueryBuilder {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($dto, $param)) {
                $query = $strategy->apply($query, $dto);
            }
        }
        return $query;
    }
}