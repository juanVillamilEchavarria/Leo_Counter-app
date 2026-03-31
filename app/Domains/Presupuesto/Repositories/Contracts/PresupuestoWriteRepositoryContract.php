<?php

namespace App\Domains\Presupuesto\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;
interface PresupuestoWriteRepositoryContract
{
    public function store(DTOContract $storePresupuestoDTO);
    public function update(Model $presupuesto, DTOContract $updatePresupuestoDTO): bool;
    public function destroy(Model $presupuesto): bool;
}
