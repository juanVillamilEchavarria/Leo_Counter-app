<?php

namespace App\Domains\MovimientoPendiente\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;
use App\Shared\Contracts\Repositories\SoftDeleteWriteRepositoryContract;

interface MovimientoPendienteWriteRepositoryContract extends SoftDeleteWriteRepositoryContract
{
    public function store(DTOContract $storeMovimientoPendienteDTO);
    public function update(Model $movimientoPendiente, DTOContract $updateMovimientoPendienteDTO): bool;
    public function destroy(Model $movimientoPendiente): bool;
}
