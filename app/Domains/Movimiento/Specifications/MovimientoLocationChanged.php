<?php

namespace App\Domains\Movimiento\Specifications;
use App\Models\Movimiento\Movimiento;
use App\Domains\Movimiento\DTOs\UpdateMovimientoDTO;

final class MovimientoLocationChanged {
    public function isSatisfiedBy(Movimiento $movimiento, UpdateMovimientoDTO $dto): bool {
        return $movimiento->categoria_id !== $dto->categoria_id || $movimiento->tipo_movimiento_id !== $dto->tipo_movimiento_id;
    }
}