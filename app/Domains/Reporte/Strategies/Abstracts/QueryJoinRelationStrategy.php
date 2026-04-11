<?php

namespace App\Domains\Reporte\Strategies\Abstracts;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Contracts\Strategies\QueryRelationStrategyContract;
use App\Shared\Domain\Contracts\Reporte\QueryRelationParamContract;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use App\Shared\Domain\QueryBuilders\DomainQueryBuilder;
use App\Shared\Enums\ComparativeOperators;
/**
 * Clase para realizar un join complejo en la consulta, filtrando por parametros dinamicos de la relacion y where, Aplica unicamente la logica de comparacion para obtener los registros y opcionalmente el where, los atributos a seleccionar deben ser declarados antes de implementar la funcionalidad de esta clase
 * @example SELECT categorias.nombre as categoria, movimientos.monto as monto FROM movimientos INNER JOIN categorias ON movimientos.categoria_id = categorias.id WHERE movimientos.monto > 1000
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
abstract class QueryJoinRelationStrategy implements QueryRelationStrategyContract{

    /**
     * @param string $table
     * @param string $relationTable
     * @param string $relationColumn
     * @param string $comparativeColumn
     * @param ?WhereFilterQueryDTO $where
     * @param string $dtoProperty
     */

    /**
     * Tabla que contiene la relacion (principal)
     * Ej: movimientos
     */
    protected string $table;
    /**
     * Tabla a la cual se realizara el join
     * Ej: categorias
     */
    protected string $relationTable;
    /**
     * La columna de la tabla principal que se utilizara para realizar el join
     * Ej: movimientos.categoria_id
     */
    protected string $relationColumn;
    /**
     * La columna de la tabla a la cual se realizara el join
     * Ej: categorias.id
     */
    protected string $comparativeColumn = 'id';
    /**
     * Los filtros que se aplicaran a la tabla a la cual se realizara el join
     * 
     */
    protected ?WhereFilterQueryDTO $where = null;
    /**
     * El operador que se utilizara para realizar la comparacion
     */
    protected ComparativeOperators $joinOperator = ComparativeOperators::EQUALS;

    /**
     * 
     * @param ReporteQueryDTO $reporteQueryDTO
     * funcion para declarar la propiedad del dto que se utilizara para realizar el join y verificar si se debe realizar el join
     */
    abstract protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): mixed;
    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParamContract $param) {
        return !is_null($this->dtoProperty($reporteQueryDTO)) && $this->table === $param->value;
    }

    public function apply(DomainQueryBuilder $query, ReporteQueryDTO $reporteQueryDTO){
        if(!$query->hasJoin($this->relationTable)){
            $query = $query->join($this->relationTable, $this->relationColumn, $this->joinOperator->value, $this->comparativeColumn);
        }
        $wheres = $this->wheres();
        if(!is_null($wheres)){
            /**
             * @var WhereFilterQueryDTO $where
             */
            foreach($wheres as $where){
                $query->where($where->column, $where->operator->value, $where->value, $where->logic);
            }
        }
        return $query;
    }

    /**
     * 
     * @return array<WhereFilterQueryDTO> | null
     */
     protected function wheres(): ?array{
        return null;
     }
}