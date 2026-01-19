<?php

namespace App\Domains\MovimientoFijo\Actions;

use App\Models\MovimientoFijo\MovimientoFijo;
use DomainException;
class UpdateMovimientoFijoAction{
    public function toggleActive(MovimientoFijo $movimientoFijo): bool{
        if(!$movimientoFijo){
            throw new DomainException('El movimiento fijo no existe');
        }
        return $movimientoFijo->update(['active' => !$movimientoFijo->active]);
        
    }

    public function toggleRegistrarAutomatico(MovimientoFijo $movimientoFijo): bool{
        if(!$movimientoFijo){
            throw new DomainException('El movimiento fijo no existe');
        }
        return $movimientoFijo->update(['registrar_automatico' => !$movimientoFijo->registrar_automatico]);
        
    }
}