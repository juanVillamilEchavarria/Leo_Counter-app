<?php 

namespace App\Domains\MovimientoFijo\Actions;

use App\Models\MovimientoFijo\MovimientoFijo;
use App\Domains\MovimientoFijo\DTOs\StoreMovimientoFijoDTO;
class StoreMovimientoFijoAction
{
    public function store(StoreMovimientoFijoDTO $dto): MovimientoFijo
    {
        return MovimientoFijo::create($dto->toArray());
    }
}