<?php

namespace App\Domains\Reporte\Contracts\Strategies;
use App\Shared\Domain\QueryBuilders\DomainQueryBuilder;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\Domain\Contracts\Reporte\QueryRelationParamContract;

interface QueryRelationStrategyContract{
    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParamContract $param);
    public function apply(DomainQueryBuilder $query, ReporteQueryDTO $reporteQueryDTO);
}