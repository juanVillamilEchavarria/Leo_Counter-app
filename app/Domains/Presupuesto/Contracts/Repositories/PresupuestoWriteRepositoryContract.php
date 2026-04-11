<?php

namespace App\Domains\Presupuesto\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;
use App\Shared\Contracts\Repositories\SoftDeleteWriteRepositoryContract;
interface PresupuestoWriteRepositoryContract extends SoftDeleteWriteRepositoryContract
{
    public function store(DTOContract $storePresupuestoDTO);
    public function update(Model $presupuesto, DTOContract $updatePresupuestoDTO): bool;
    public function destroy(Model $presupuesto): bool;
}
