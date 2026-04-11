<?php

namespace App\Domains\Movimiento\Strategies\Application;
use App\Domains\Movimiento\Strategies\Domain\GastoResolveStrategy;
use App\Domains\Movimiento\Strategies\Domain\IngresoResolveStrategy;
use App\Domains\Movimiento\Contracts\Strategies\CuentaResolveStrategy;
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

    public function resolve(int $tipo_movimiento_id, int $cuenta_id, float $monto, ?int $movimiento_id = null) : Cuenta{
        foreach($this->getStrategies() as $strategy){
            if($strategy->supports($tipo_movimiento_id)){

                return $strategy->resolve($cuenta_id, $monto, $movimiento_id);
            }
        }
        throw new \InvalidArgumentException("Tipo de movimiento no soportado");
    }
}