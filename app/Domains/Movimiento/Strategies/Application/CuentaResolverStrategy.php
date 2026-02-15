<?php

namespace App\Domains\Movimiento\Strategies\Application;
use App\Domains\Movimiento\Strategies\Domain\GastoResolveStrategy;
use App\Domains\Movimiento\Strategies\Domain\IngresoResolveStrategy;
use App\Domains\Movimiento\Contracts\CuentaResolveStrategy;
use App\Models\Cuenta\Cuenta;

class CuentaResolverStrategy{

    /**
     * @param CuentaResolveStrategy[] $strategies
     */
    public function __construct(
        private GastoResolveStrategy $gastoResolveStrategy,
        private IngresoResolveStrategy $ingresoResolveStrategy,
    )
    {
    }

    private function getStrategies() : array{
        return [
            $this->gastoResolveStrategy,
            $this->ingresoResolveStrategy,
        ];
    }

    public function resolve(int $tipo_movimiento_id, int $cuenta_id, float $monto) : Cuenta{
        foreach($this->getStrategies() as $strategy){
            if($strategy->supports($tipo_movimiento_id)){
                return $strategy->resolve($cuenta_id, $monto);
            }
        }
        throw new \InvalidArgumentException("Tipo de movimiento no soportado");
    }
}