<?php


namespace App\Domains\Movimiento\Actions;

use App\Models\Movimiento\Movimiento;
use App\Domains\Movimiento\DTOs\UpdateMovimientoDTO;
use App\Domains\Movimiento\Exceptions\CannotUpdateMovimientoException;

class UpdateMovimientoAction
{
    public function update(Movimiento $movimiento, UpdateMovimientoDTO $dto): bool{
        return $movimiento->update($dto->toArray());
    }
}