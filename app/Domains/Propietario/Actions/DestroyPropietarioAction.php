<?php

namespace App\Domains\Propietario\Actions;

use App\Models\Propietario\Propietario;
use DomainException;

class DestroyPropietarioAction{
    public function destroy(Propietario $propietario): bool
    {
        if(!$propietario){
            throw new DomainException('El propietario no existe');
        }
        return $propietario->delete();
       
    }
}