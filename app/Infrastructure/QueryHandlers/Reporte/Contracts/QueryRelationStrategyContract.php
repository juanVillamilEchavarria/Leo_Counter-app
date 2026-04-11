<?php

namespace App\Infrastructure\QueryHandlers\Reporte\Contracts;

use App\Shared\Domain\Contracts\Reporte\QueryRelationParamContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\Domain\QueryBuilders\DomainQueryBuilder;

interface QueryRelationStrategyContract
{
    public function supports(ReporteQueryDTO $dto, QueryRelationParamContract $param): bool;
    public function apply(DomainQueryBuilder $query, ReporteQueryDTO $dto): DomainQueryBuilder;
}