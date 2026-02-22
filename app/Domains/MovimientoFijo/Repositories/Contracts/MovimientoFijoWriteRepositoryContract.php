<?php

namespace App\Domains\MovimientoFijo\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;
use App\Models\MovimientoFijo\MovimientoFijo;

interface MovimientoFijoWriteRepositoryContract
{
    public function store(DTO $storeMovimientoFijoDTO);
    public function update(Model $movimientoFijo, DTO $updateMovimientoFijoDTO): bool;
    public function destroy(Model $movimientoFijo): bool;
    public function toggleActive(MovimientoFijo $movimientoFijo): bool;
    public function toggleRegistrarAutomaticamente(MovimientoFijo $movimientoFijo): bool;
}
