<?php

namespace App\Domains\ArchivoMovimiento\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;

interface ArchivoMovimientoWriteRepositoryContract
{
    public function store(DTOContract $storeArchivoMovimientoDTO);
    public function update(Model $archivoMovimiento, DTOContract $updateArchivoMovimientoDTO): bool;
    public function destroy(Model $archivoMovimiento): bool;
}
