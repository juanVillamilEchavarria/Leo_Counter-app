<?php

namespace App\Domains\Movimiento\Contracts;

interface CuentaResolveStrategyContract
{
    public function resolve(int $cuenta_id, float $monto);
    public function supports(int $tipo_movimiento_id): bool;
}