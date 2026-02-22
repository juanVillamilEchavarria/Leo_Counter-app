<?php

namespace App\Domains\MovimientoPendiente\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;

interface MovimientoPendienteWriteRepositoryContract
{
    public function store(DTO $storeMovimientoPendienteDTO);
    public function update(Model $movimientoPendiente, DTO $updateMovimientoPendienteDTO): bool;
    public function destroy(Model $movimientoPendiente): bool;
}
