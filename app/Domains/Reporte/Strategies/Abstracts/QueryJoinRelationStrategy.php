<?php

namespace App\Domains\Reporte\Strategies\Abstracts;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\Strategies\Contracts\QueryRelationStrategyContract;
use App\Domains\Reporte\Strategies\Enums\QueryRelationParam;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use Illuminate\Database\Query\Builder;
use App\Shared\Enums\ComparativeOperators;
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
    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParam $param) {
        return !is_null($this->dtoProperty($reporteQueryDTO)) && $this->table === $param->value;
    }

    public function apply(Builder $query, ReporteQueryDTO $reporteQueryDTO){
        !$this->hasJoin($query, $this->relationTable) && $query = $query->join($this->relationTable, $this->relationColumn, $this->joinOperator->value, $this->comparativeColumn);
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

     /**
      * verifica si la query tiene un join a la tabla especificada
      */
     private function hasJoin(Builder $query, string $table): bool {
        if (!$query->joins) {
            return false;
        }
        return collect($query->joins)
            ->pluck('table')
            ->contains(function ($joinTable) use ($table) {
                // Normalizar nombres (eliminar alias, espacios, case)
                $normalized = strtolower(trim(explode(' as ', $joinTable)[0]));
                return $normalized === strtolower(trim($table));
            });
    }
}