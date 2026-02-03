<?php

namespace App\Domains\MovimientoPendiente\Actions;

use App\Models\MovimientoPendiente\MovimientoPendiente;

class DestroyMovimientoPendienteAction{
    public function destroy(MovimientoPendiente $movimientoPendiente): bool{
        return $movimientoPendiente->delete();
    }
}
