<?php

namespace App\Infrastructure\Reporte\Contracts\Queries;

use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\Infrastructure\QueryBuilders\DomainQueryBuilder;

interface ReporteQueryRelationStrategyContract
{
    public function supports(ReporteQueryDTO $dto, QueryRelationParamContract $param): bool;
    public function apply(DomainQueryBuilder $query, ReporteQueryDTO $dto): DomainQueryBuilder;
}
