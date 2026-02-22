<?php

namespace App\Domains\ArchivoMovimiento\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;

interface ArchivoMovimientoWriteRepositoryContract
{
    public function store(DTO $storeArchivoMovimientoDTO);
    public function update(Model $archivoMovimiento, DTO $updateArchivoMovimientoDTO): bool;
    public function destroy(Model $archivoMovimiento): bool;
}
