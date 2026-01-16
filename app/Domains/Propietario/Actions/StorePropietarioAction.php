<?php

namespace App\Domains\Propietario\Actions;
use App\Models\Propietario\Propietario;
use App\Domains\Propietario\DTOs\StoreAndUpdatePropietarioDTO;
use Symfony\Component\HttpKernel\HttpCache\Store;

class StorePropietarioAction
{
    public function store(StoreAndUpdatePropietarioDTO $dto): Propietario
    {
        return Propietario::create($dto->toArray());

        
    }
}