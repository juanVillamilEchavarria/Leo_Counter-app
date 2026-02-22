<?php

namespace App\Domains\Presupuesto\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;

interface PresupuestoWriteRepositoryContract
{
    public function store(DTO $storePresupuestoDTO);
    public function update(Model $presupuesto, DTO $updatePresupuestoDTO): bool;
    public function destroy(Model $presupuesto): bool;
}
