<?php

namespace App\Domains\Movimiento\Strategies\Domain;

use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Domains\Movimiento\Contracts\CuentaResolveStrategyContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

class IngresoResolveStrategy implements CuentaResolveStrategyContract{

    public function __construct(
        private GetCuentaAction $getCuentaAction
    )
    {
    }
    public function resolve(int $cuenta_id, float $monto) {
        return $this->getCuentaAction->where('id', $cuenta_id)->firstOrFail();
    }

    public function supports(int $tipo_movimiento_id): bool
    {
        return $tipo_movimiento_id === TipoMovimientoEnum::INGRESO->value;
    }
}