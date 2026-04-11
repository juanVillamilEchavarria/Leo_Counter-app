<?php

namespace App\Domains\Reporte\Strategies\Abstracts;
use App\Shared\Domain\QueryBuilders\DomainQueryBuilder;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Contracts\Strategies\QueryRelationStrategyContract;
use App\Shared\Domain\Contracts\Reporte\QueryRelationParamContract;
use App\Shared\DTOs\Querys\IdsDTO;
/**
 * Clase para realizar una consulta que obtiene los registros de la tabla principal, asociados al campo de relacion en un array de ids
 * Ejemplo de consulta: SELECT * FROM movimientos WHERE movimientos.categoria_id IN (1,2,3)
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
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
     * @return IdsDTO
     * Funcion para declarar la propiedad del dto que se utilizara para realizar el filtrado de la consulta y verificar si se debe realizar el join
     */
    abstract protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): IdsDTO | null;
    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParamContract $param) {
        return !is_null($this->dtoProperty($reporteQueryDTO)) && $this->table === $param->value;
    }

    public function apply(DomainQueryBuilder $query, ReporteQueryDTO $reporteQueryDTO) {

        return $query->whereIn($this->relationColumn, $this->dtoProperty($reporteQueryDTO)->toArray()['ids']);
    }

    public function setRelationColumn(string $relationColumn){
        $this->relationColumn = $relationColumn;
    }
}