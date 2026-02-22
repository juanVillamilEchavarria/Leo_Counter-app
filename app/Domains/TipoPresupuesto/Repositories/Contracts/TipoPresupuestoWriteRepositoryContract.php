<?php

namespace App\Domains\TipoPresupuesto\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;

interface TipoPresupuestoWriteRepositoryContract
{
    public function store(DTO $storeTipoPresupuestoDTO);
    public function update(Model $tipoPresupuesto, DTO $updateTipoPresupuestoDTO): bool;
    public function destroy(Model $tipoPresupuesto): bool;
}
