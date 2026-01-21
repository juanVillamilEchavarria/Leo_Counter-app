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
        return $cuenta->update([
            'archived' => true
        ]); // realmete la archiva, no la elimina, esto se hace para mantener la integridad de los datos
    }
}