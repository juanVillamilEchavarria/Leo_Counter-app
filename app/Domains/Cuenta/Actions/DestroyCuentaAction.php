<?php

namespace App\Domains\Cuenta\Actions;

use App\Models\Cuenta\Cuenta;
use App\Domains\Cuenta\Exceptions\CannotDeleteCuentaException;

class DestroyCuentaAction
{
    public function destroy(Cuenta $cuenta): bool
    {
        if(!$cuenta){
            throw new CannotDeleteCuentaException;
        }
        return $cuenta->delete(); 
    }
}