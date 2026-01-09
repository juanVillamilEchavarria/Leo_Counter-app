<?php

namespace App\Domains\Cuenta\Actions;

use App\Models\Cuenta\Cuenta;
use App\Domains\Cuenta\DTOs\UpdateCuentaDTO;
use DomainException;

class UpdateCuentaAction
{
    public function update(Cuenta $cuenta, UpdateCuentaDTO $dto): bool
    {
        if(!$cuenta){
           throw new DomainException('La cuenta no existe');
        }
       return $cuenta->update($dto->toArray());

    }


    public function toggleActive(Cuenta $cuenta): bool{
        if(!$cuenta){
            throw new DomainException('La cuenta no existe');
        }
        return $cuenta->update(['active' => !$cuenta->active]);
    }
}