<?php

namespace App\Domains\Movimiento\Contracts\Strategies;

interface CuentaResolveStrategyContract
{
    public function resolve(int $cuenta_id, float $monto, ?int $movimiento_id = null);
    public function supports(int $tipo_movimiento_id): bool;
}