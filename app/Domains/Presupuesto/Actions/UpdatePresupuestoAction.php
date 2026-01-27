<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use App\Domains\Presupuesto\DTOs\UpdatePresupuestoMesActualDTO;
use App\Domains\Presupuesto\DTOs\UpdatePresupuestoPorPeriodoDTO;

class UpdatePresupuestoAction
{
    public function update(Presupuesto $presupuesto, UpdatePresupuestoMesActualDTO | UpdatePresupuestoPorPeriodoDTO $dto): bool
    {
        return $presupuesto->update($dto->toArray());
    }
}
