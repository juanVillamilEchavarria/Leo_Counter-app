<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Queries\Builders;

/**
 *
 * construira una query para un aggregate con una condicion.
 *
 * Ejemplo de retornos :
 *
 * con COALESCE y conditionColumn :
 *
 * COALESCE(SUM(CASE WHEN movimientos.tipo_movimiento_id = ? THEN monto END), 0)
 *
 * con COALESCE y sin conditionColumn :
 *
 * COALESCE(SUM(monto), 0)
 *
 * sin COALESCE y conditionColumn :
 *
 * SUM(CASE WHEN movimientos.tipo_movimiento_id = ? THEN monto END)
 *
 * sin COALESCE y sin conditionColumn :
 *
 * SUM(monto)
 * @example
 * $builder = ConditionalAggregateBuilder::make()
 * ->aggregate('SUM')
 * ->column('movimientos.monto')
 * ->conditionColumn('movimientos.tipo_movimiento_id')
 * ->useCoalesce(true)
 * ->build();
 *  @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */

class ConditionalAggregateBuilder{


    /**
     * @param string $aggregate
     * @param string $column
     * @param string $conditionColumn
     * @param bool $useCoalesce
     * @param int | float $defaultValue
     * @return string
     */

    /**
     * el tipo de operacion a realizar
     */
    private string $aggregate = 'SUM';
    /**
     * el campo a operar
     */
    private string $column = 'monto';
    /**
     * el campo de la condicion
     */
    private ?string $conditionColumn = null;
    /**
     * si se va a usar COALESCE
     */
    private bool $useCoalesce = true;
    /**
     * el valor por defecto en caso de usar COALESCE, por defecto es 0, pero se puede configurar con el metodo defaultValue
     */
    private int | float $defaultValue = 0;

    /**
     * @return self
     */
    public static function make(): self{
        return new self();
    }



    /**
     * Setea el tipo de operacion a realizar
     * @param string $aggregate
     * @return self
     */
    public function aggregate(string $aggregate): self{
        $this->aggregate = $aggregate;
        return $this;
    }

    /**
     * Setea el campo a operar
     * @param string $column
     * @return self
     */
    public function column(string $column): self{
        $this->column = $column;
        return $this;
    }

    /**
     * Setea el campo de la condicion
     * @param string $conditionColumn
     * @return self
     */
    public function conditionColumn(string $conditionColumn): self{
        $this->conditionColumn = $conditionColumn;
        return $this;
    }

    /**
     * Setea si se va a usar COALESCE
     * @param bool $useCoalesce     * @return self
     */
    public function useCoalesce(bool $useCoalesce): self{
        $this->useCoalesce = $useCoalesce;
        return $this;
    }

    /**
     * Setea el valor por defecto en caso de usar COALESCE, por defecto es 0, pero se puede configurar con este metodo
     * @param int | float $defaultValue
     * @return self
     */
    public function defaultValue(int | float $defaultValue): self{
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * Construye la query completa con el COALESCE si es necesario
     * @return string
     */
    public function build(): string{
        return $this->useCoalesce ?
                "COALESCE({$this->buildQuery()}, {$this->defaultValue})":
                $this->buildQuery();

    }
    /**
     * @return string
     */
    public function __toString(): string{
        return $this->build();
    }

    /**
     * Retorna la query para el aggregate
     * Ej:
     * SUM(CASE WHEN movimientos.tipo_movimiento_id = ? THEN monto END)
     * @return string
     */
    private function buildQuery(): string{
        if($this->conditionColumn){
            $caseWhen= $this->buildWhenQuery();
            return "{$this->aggregate}({$caseWhen})";
        }
        return "{$this->aggregate}({$this->column})";
    }

    /**
     * Retorna la query para el CASE WHEN
     * @return string
     */
    private function buildWhenQuery(): string{
        return $this->aggregate === 'COUNT'?
            "CASE WHEN {$this->conditionColumn} = ? THEN 1 END" :
            "CASE WHEN {$this->conditionColumn} = ? THEN {$this->column} END";
    }
}
