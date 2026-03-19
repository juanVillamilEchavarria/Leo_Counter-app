<?php

namespace App\Domains\Reporte\Strategies\Contracts;
use Illuminate\Database\Query\Builder;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
interface QueryIdRelationStrategyContract{
    public function supports(ReporteQueryDTO $reporteQueryDTO, string $table);
    public function apply(Builder $query, ReporteQueryDTO $reporteQueryDTO);
}