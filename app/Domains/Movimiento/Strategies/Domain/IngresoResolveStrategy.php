<?php

namespace App\Domains\Movimiento\Strategies\Domain;

use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
use App\Domains\Movimiento\Strategies\Contracts\CuentaResolveStrategyContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Domains\Cuenta\Exceptions\CannotFindCuentaException;
use App\Models\Cuenta\Cuenta;

class IngresoResolveStrategy implements CuentaResolveStrategyContract{

    public function __construct(
        private CuentaReadRepositoryContract $cuentaReadRepository
    )
    {
    }
    public function resolve(int $cuenta_id, float $monto, ?int $movimiento_id = null): Cuenta {
        try {
            $cuenta = $this->cuentaReadRepository->whereAttr('id', $cuenta_id)->firstOrFail();
            return $cuenta;
        } catch (\Throwable $th) {
            throw new CannotFindCuentaException('No se encontro la cuenta asociada al movimiento, error: ' . $th->getMessage());
        }
    }

    public function supports(int $tipo_movimiento_id): bool
    {
        return $tipo_movimiento_id === TipoMovimientoEnum::INGRESO->value;
    }
}