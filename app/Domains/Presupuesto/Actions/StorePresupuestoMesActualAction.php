<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use App\Domains\Presupuesto\DTOs\StorePresupuestoDTO;
use Illuminate\Session\Store;

class StorePresupuestoMesActualAction{
    public function store(StorePresupuestoDTO $dto): Presupuesto{
        return Presupuesto::create($dto->toArray());
    }
}