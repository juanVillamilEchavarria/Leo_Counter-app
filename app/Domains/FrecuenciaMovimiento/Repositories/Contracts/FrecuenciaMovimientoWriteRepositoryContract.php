<?php

namespace App\Domains\FrecuenciaMovimiento\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;

interface FrecuenciaMovimientoWriteRepositoryContract
{
    public function store(DTOContract $storeFrecuenciaMovimientoDTO);
    public function update(Model $frecuenciaMovimiento, DTOContract $updateFrecuenciaMovimientoDTO): bool;
    public function destroy(Model $frecuenciaMovimiento): bool;
}
