<?php

namespace App\Domains\MovimientoFijo\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;
use App\Models\MovimientoFijo\MovimientoFijo;
use App\Application\MovimientoFijo\DTOs\Contracts\MovimientoFijoDTOContract;
interface MovimientoFijoRepositoryContract
{
    public function store(MovimientoFijoDTOContract $storeMovimientoFijoDTO);
    public function update(Model $movimientoFijo, MovimientoFijoDTOContract $updateMovimientoFijoDTO): bool;
    public function destroy(Model $movimientoFijo): bool;
    public function toggle(Model $movimientoFijo, string $attribute): bool;
}
