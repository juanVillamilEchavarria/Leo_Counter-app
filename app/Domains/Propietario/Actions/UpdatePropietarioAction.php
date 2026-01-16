<?php

namespace App\Domains\Propietario\Actions;

use App\Models\Propietario\Propietario;
use App\Domains\Propietario\DTOs\StoreAndUpdatePropietarioDTO;
use DomainException;

class UpdatePropietarioAction{
    public function update(Propietario $propietario, StoreAndUpdatePropietarioDTO $dto): bool
    {
        if(!$propietario){
            throw new DomainException('El propietario no existe');
        }
        return $propietario->update($dto->toArray());
       
    }
}