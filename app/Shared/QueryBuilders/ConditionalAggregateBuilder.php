<?php
namespace App\Shared\QueryBuilders;

/**
 * construira una query para un aggregate con una condicion
 * ejemplo de retornos :
 * con COALESCE y conditionColumn : 
 * COALESCE(SUM(CASE WHEN movimientos.tipo_movimiento_id = ? THEN monto END), 0)
 * 
 * con COALESCE y sin conditionColumn :
 * COALESCE(SUM(monto), 0)
 * 
 * sin COALESCE y conditionColumn :
 * SUM(CASE WHEN movimientos.tipo_movimiento_id = ? THEN monto END)
 * 
 * sin COALESCE y sin conditionColumn :
 * SUM(monto)
 */

class ConditionalAggregateBuilder{
    
    /**
     * Ejemplo de instanciacion:
     * $builder = ConditionalAggregateBuilder::make()
     * ->aggregate('SUM')
     * ->column('movimientos.monto')
     * ->conditionColumn('movimientos.tipo_movimiento_id')
     * ->useCoalesce(true)
     * ->build();
     */

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
    private ?string $conditionColumn = null; 
    private bool $useCoalesce = true;
    private int | float $defaultValue = 0;
    
    public static function make(): self{
        return new self();
    }

    /**
     * Metodos para configurar el objeto
     */

    public function aggregate(string $aggregate): self{
        $this->aggregate = $aggregate;
        return $this;
    }

    public function column(string $column): self{
        $this->column = $column;
        return $this;
    }

    public function conditionColumn(string $conditionColumn): self{
        $this->conditionColumn = $conditionColumn;
        return $this;
    }

    public function useCoalesce(bool $useCoalesce): self{
        $this->useCoalesce = $useCoalesce;
        return $this;
    }

    public function defaultValue(int | float $defaultValue): self{
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * Construye la query completa con el COALESCE si es necesario
     */
    public function build(): string{
        return $this->useCoalesce ?
                "COALESCE({$this->buildQuery()}, {$this->defaultValue})":
                $this->buildQuery();

    }
    public function __toString(): string{
        return $this->build();
    }

    /**
     * Retorna la query para el aggregate
     * Ej:
     * SUM(CASE WHEN movimientos.tipo_movimiento_id = ? THEN monto END)
     */
    private function buildQuery(): string{
        if($this->conditionColumn){
            $caseWhen= $this->buildWhenQuery();
            return "{$this->aggregate}({$caseWhen})";
        }
        return "{$this->aggregate}({$this->column})";
    }

    private function buildWhenQuery(): string{
        return $this->aggregate === 'COUNT'?
            "CASE WHEN {$this->conditionColumn} = ? THEN 1 END" :
            "CASE WHEN {$this->conditionColumn} = ? THEN {$this->column} END";
    }
}