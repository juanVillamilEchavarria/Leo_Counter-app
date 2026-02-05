<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use App\Domains\Presupuesto\DTOs\StorePresupuestoMesActualDTO;
use Illuminate\Session\Store;

class StorePresupuestoAction{
    public function store(StorePresupuestoMesActualDTO $dto): Presupuesto{
        return Presupuesto::create($dto->toArray());
    }
}