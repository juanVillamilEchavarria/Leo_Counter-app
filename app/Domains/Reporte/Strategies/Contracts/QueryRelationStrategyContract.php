<?php

namespace App\Domains\Reporte\Strategies\Contracts;
use Illuminate\Database\Query\Builder;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\Strategies\Enums\QueryRelationParam;
interface QueryRelationStrategyContract{
    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParam $param);
    public function apply(Builder $query, ReporteQueryDTO $reporteQueryDTO);
}