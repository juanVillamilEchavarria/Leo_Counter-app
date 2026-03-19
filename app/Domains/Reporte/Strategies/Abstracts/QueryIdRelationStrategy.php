<?php

namespace App\Domains\Reporte\Strategies\Abstracts;
use Illuminate\Database\Query\Builder;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Shared\DTOs\Querys\IdsDTO;
abstract class QueryIdRelationStrategy {
    /**
     * Tabla que contiene la relacion
     */

    protected string $table;
    /**
     * Columna que contiene la relacion
     * Formato Ej: movimientos.categoria_id
     */
    protected string $relationColumn;
    /**
     * Propiedad del DTO que contiene los ids
     * Ej: movimientos
     */
    protected string $dtoProperty; 
    public function supports(ReporteQueryDTO $reporteQueryDTO, string $table) {
        return !is_null($reporteQueryDTO->{$this->dtoProperty}) && $this->table === $table;
    }

    public function apply(Builder $query, ReporteQueryDTO $reporteQueryDTO) {
        /**
         * @var IdsDTO $reporteQueryDTO{$this->dtoProperty}
         */
        return $query->whereIn($this->relationColumn, $reporteQueryDTO->{$this->dtoProperty}->toArray()['ids']);
    }

    public function setRelationColumn(string $relationColumn){
        $this->relationColumn = $relationColumn;
    }
    public function setDtoProperty(string $dtoProperty){
        $this->dtoProperty = $dtoProperty;
    }
}