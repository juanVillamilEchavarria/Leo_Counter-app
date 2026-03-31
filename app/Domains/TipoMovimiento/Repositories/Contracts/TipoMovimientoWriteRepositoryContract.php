<?php

namespace App\Domains\TipoMovimiento\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;

interface TipoMovimientoWriteRepositoryContract
{
    public function store(DTOContract $storeTipoMovimientoDTO);
    public function update(Model $tipoMovimiento, DTOContract $updateTipoMovimientoDTO): bool;
    public function destroy(Model $tipoMovimiento): bool;
}
