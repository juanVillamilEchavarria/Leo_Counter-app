<?php

namespace App\Domains\MovimientoFijo\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;
use App\Models\MovimientoFijo\MovimientoFijo;
use App\Domains\MovimientoFijo\DTOs\Contracts\MovimientoFijoDTOContract;
interface MovimientoFijoWriteRepositoryContract
{
    public function store(MovimientoFijoDTOContract $storeMovimientoFijoDTO);
    public function update(Model $movimientoFijo, MovimientoFijoDTOContract $updateMovimientoFijoDTO): bool;
    public function destroy(Model $movimientoFijo): bool;
    public function toggle(Model $movimientoFijo, string $attribute): bool;
}
