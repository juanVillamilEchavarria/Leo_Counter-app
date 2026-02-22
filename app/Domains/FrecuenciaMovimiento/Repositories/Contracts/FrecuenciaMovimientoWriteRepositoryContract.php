<?php

namespace App\Domains\FrecuenciaMovimiento\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;

interface FrecuenciaMovimientoWriteRepositoryContract
{
    public function store(DTO $storeFrecuenciaMovimientoDTO);
    public function update(Model $frecuenciaMovimiento, DTO $updateFrecuenciaMovimientoDTO): bool;
    public function destroy(Model $frecuenciaMovimiento): bool;
}
