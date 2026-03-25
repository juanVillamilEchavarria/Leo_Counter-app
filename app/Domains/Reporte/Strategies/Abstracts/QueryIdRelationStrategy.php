<?php

namespace App\Domains\Reporte\Strategies\Abstracts;
use Illuminate\Database\Query\Builder;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\Strategies\Contracts\QueryRelationStrategyContract;
use App\Domains\Reporte\Strategies\Enums\QueryRelationParam;
use App\Shared\DTOs\Querys\IdsDTO;
abstract class QueryIdRelationStrategy implements QueryRelationStrategyContract {
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
    /**
     * @return IdsDTO
     * Funcion para declarar la propiedad del dto que se utilizara para realizar el filtrado de la consulta y verificar si se debe realizar el join
     */
    abstract protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): IdsDTO | null;
    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParam $param) {
        return !is_null($this->dtoProperty($reporteQueryDTO)) && $this->table === $param->value;
    }

    public function apply(Builder $query, ReporteQueryDTO $reporteQueryDTO) {

        return $query->whereIn($this->relationColumn, $this->dtoProperty($reporteQueryDTO)->toArray()['ids']);
    }

    public function setRelationColumn(string $relationColumn){
        $this->relationColumn = $relationColumn;
    }
    public function setDtoProperty(string $dtoProperty){
        $this->dtoProperty = $dtoProperty;
    }
}