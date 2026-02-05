<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use App\Domains\Presupuesto\DTOs\UpdatePresupuestoMesActualDTO;

class UpdatePresupuestoAction
{
    public function update(Presupuesto $presupuesto, UpdatePresupuestoMesActualDTO $dto): bool
    {
        return $presupuesto->update($dto->toArray());
    }
}
