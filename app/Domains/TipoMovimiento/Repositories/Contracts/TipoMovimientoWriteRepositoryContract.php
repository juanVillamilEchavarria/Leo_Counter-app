<?php

namespace App\Domains\TipoMovimiento\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;

interface TipoMovimientoWriteRepositoryContract
{
    public function store(DTO $storeTipoMovimientoDTO);
    public function update(Model $tipoMovimiento, DTO $updateTipoMovimientoDTO): bool;
    public function destroy(Model $tipoMovimiento): bool;
}
