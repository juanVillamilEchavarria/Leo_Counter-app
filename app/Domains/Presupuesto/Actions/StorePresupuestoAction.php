<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use App\Domains\Presupuesto\DTOs\StorePresupuestoMesActualDTO;
use App\Domains\Presupuesto\DTOs\StorePresupuestoPorPeriodoDTO;
use Illuminate\Session\Store;

class StorePresupuestoAction{
    public function store(StorePresupuestoMesActualDTO | StorePresupuestoPorPeriodoDTO $dto): Presupuesto{
        return Presupuesto::create($dto->toArray());
    }
}