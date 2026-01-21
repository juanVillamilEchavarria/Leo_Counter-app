<?php

namespace App\Domains\MovimientoFijo\Actions;

use App\Models\MovimientoFijo\MovimientoFijo;

class DestroyMovimientoFijoAction{
    public function destroy(MovimientoFijo $movimientoFijo): bool{
        return $movimientoFijo->delete();
    }
}