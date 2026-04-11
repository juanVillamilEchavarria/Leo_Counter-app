<?php

namespace App\Domains\TipoPresupuesto\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;

interface TipoPresupuestoWriteRepositoryContract
{
    public function store(DTOContract $storeTipoPresupuestoDTO);
    public function update(Model $tipoPresupuesto, DTOContract $updateTipoPresupuestoDTO): bool;
    public function destroy(Model $tipoPresupuesto): bool;
}
