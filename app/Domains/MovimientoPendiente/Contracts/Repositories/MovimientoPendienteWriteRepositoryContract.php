<?php

namespace App\Domains\MovimientoPendiente\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;
use App\Shared\Contracts\Repositories\SoftDeleteRepositoryContract;

interface MovimientoPendienteRepositoryContract extends SoftDeleteRepositoryContract
{
    public function store(DTOContract $storeMovimientoPendienteDTO);
    public function update(Model $movimientoPendiente, DTOContract $updateMovimientoPendienteDTO): bool;
    public function destroy(Model $movimientoPendiente): bool;
}
